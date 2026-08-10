<?php

namespace App\Http\Livewire\Utils;

use App\Helpers\Helper;
use App\Models\CallLog;
use App\Models\QrDetails;
use App\Models\SmsOption;
use App\Notifications\NewMessage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class QrConnect extends Component
{   
    use WithRateLimiting;
    public $qr_detail = null;
    public $call_status = false;
    public $call_at = null;
    public $message = null;
    public $sms_to_emergency = 0;
    public $sms_options = [];
    public $sender;
    public $receiver;
    public $confirmCall = false;
    
    protected $listeners = ['refreshComponent' => '$refresh'];

    function rules(){

        return [
            'message' => 'required',
        ];
        
    } 

    public function mount($qr_detail){
        $this->sender = auth()->user();
        $this->receiver = $qr_detail->user;
        $this->qr_detail = $qr_detail;
        $this->sms_options = SmsOption::all();
    }

    public function render(){
        return view('livewire.utils.qr-connect');
    }

    public function makeCall($type){

        try {
            
            $this->rateLimit(CALL_RATE_LIMIT);

            Log::info('Making Call');
            QrDetails::find($this->qr_detail->id)->increment('call_impressions');
            if(!Auth::check()) abort(401);
            
            if($type == 'emergency'){
                Log::info('Preparing Emergency Call');
                $to = $this->qr_detail->user->phone; // to the qr owner
                $res = $this->triggerCall($to);

            }elseif($type == 'primary'){
                Log::info('Preparing Primary Call');
                $to = $this->qr_detail->user->phone; // to the qr owner
                $res = $this->triggerCall($to);

            }
            
            if($res == 200 || $res == 202){

                Log::info('Call Successed: '. $to);
                $this->call_status = true;

            }else{
                Log::info('Call Failed: '. $to);
                $this->emit('alert', 'error', 'Sorry we could not connect you to the owner. Please try after some time or leave a message');

            }

        } catch (TooManyRequestsException $exception) {
            $this->emit('alert', 'error', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to log in.");
            return;
        }
        

    }

    public function triggerCall($to){
        
        if(app()->environment('production') && url('') == 'https://ezesticker.com'){
            return $this->kaleyraCall($to);
        }else{
            return $this->knowlarityCall($to);
        }

    }

    public function sendSms(){

        $this->validate();

        $message = $this->sender->messages()->create([
            'message' => $this->message,
            'receiver_id' => $this->receiver->id
        ]);
        
        $phone = $this->sms_to_emergency ? $this->qr_detail->emergency_phone : '';
        $this->receiver->notify(new NewMessage($this->receiver, $message, $phone, $this->qr_detail->id));
        $this->message = null;

        $this->emit('alert', 'success', 'Your message is sent successfully to the owner');
        $this->emit('close-modal', '#openSmsText');
        $this->emit('refreshComponent');

    }

    public function selectedSms($message){

        $this->sms_message = $message;
        $this->message = $message;

    }

    public function callAgain($callAgain){
        $this->call_status = $callAgain;

    }

    private function knowlarityCall($to){
        
        try {

            $from = auth()->user()->phone; // from scanned user
            Log::info('Call From: '.$from.' , Call To: '. $to);
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => '49ca7a02-897e-4b45-a78e-004590717f2b',
                'x-api-key' => 'qRwE4Ugq4C3XJfNlUWUkl3CpwZ77ryWradPalKfY'
            ];

            $body = '{
                "k_number": "+917303429701",
                "agent_number": "+91'.$from.'",
                "customer_number": "+91'.$to.'",
                "caller_id": "+917303429701"
            }';
            
            
            $client = new Client(['headers' => $headers]);
            $res = $client->post('https://kpi.knowlarity.com/Basic/v1/account/call/makecall', ['body' => $body ]);
            
            // FAKE CALLBACK REPORT FOR KNOWLARITY
            $last = CallLog::create(['to' => $this->receiver->id, 'from' => auth()->id()]);
            $url = route('dlr_url').'?call_log_id='.Helper::encodeId($last->id).'&status=ANSWER&starttime='.Carbon::now()->timestamp.'&endtime='.Carbon::now()->addMinute(1)->timestamp.'&duration=60&call_id=8cd1d0c1-d0cd-4b23-aa67-590229214c75&ivr_id=NA&ring_time=25&credits=1.3202&billsec=8&call_type=Outgoing&callee=91'.$from.'&caller=91'.$to.'&bridge=912063116111';
            $client = new Client();
            $client->get($url);

            return $res->getStatusCode();

        }catch (ClientException $e) {
            $response = $e->getResponse();
            // $response->getBody()->getContents();
            Log::error(json_encode($response));
        }
    }

    private function kaleyraCall($to){
        
        try {

            $from = auth()->user()->phone; // from scanned user

            Log::info('Call Initiated from: '. $from.' to:'. $to);
            $last = CallLog::create(['to' => $this->qr_detail->user->id, 'from' => auth()->id()]);

            $dlr_url = route('dlr_url').'?call_log_id='.Helper::encodeId($last->id).'&status={status}&starttime={starttime}&endtime={endtime}&duration={duration}&call_id={id}&ivr_id={flow_id}&ring_time={ringtime}&credits={credits}&billsec={billsec}&call_type={call_type}&callee={callee}&caller={caller}&bridge={bridge}';
            $client = new Client();
            $URI = 'https://api.kaleyra.io/v1/HXIN1703430471IN/voice/click-to-call';
            $params['headers'] = ['Content-Type' => 'application/x-www-form-urlencoded', 'api-key' => KALEYRA_API_KEY];
            $params['form_params'] = array(
                'from' => $from, 
                'to' => $to, 
                'bridge' => BRIDGE_1, 
                'prefix' => 91,
                'dlrurl' => $dlr_url
            );
            
            $res = $client->post($URI, $params);
            return $res->getStatusCode();
        }catch (ClientException $e) {
            $response = $e->getResponse();
            Log::error($response->getBody()->getContents());
        }
    }
}
