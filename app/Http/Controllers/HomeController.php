<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Jobs\IncompleteOrderJob;
use App\Mail\IncompleteOrder;
use App\Models\CallLog;
use App\Models\Faq;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\QrCode;
use App\Models\QrDetails;
use App\Models\User;
use App\Notifications\CustomerFeedback;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        return view('home');
    }

    public function showProduct($slug)
    { 
        $data['product'] = Product::where('slug', $slug)->first(); 
        if(empty($data['product'])) abort(503, 'Product Not Found');
        return view('shop.single_product', $data);
    }

    public function showCart()
    {
        return view('shop.show_cart');
    }

    public function showCheckout()
    { 
        return view('shop.show_checkout');
    }

    public function showShop()
    { 
         return view('shop.show_shop');
    }
    
    public function showQrDetails($qr_id)
    { 
        $qr = QrCode::find(Helper::decodeIdForQr($qr_id));
        if(empty($qr)){
            abort(404);
        }
        
        
        $data['qr_detail'] = QrDetails::with(['qr_code', 'user'])->where('qr_code_id', $qr->id)->first();
        if(!empty($data['qr_detail']) && $data['qr_detail']->status == 'InActive'){
            abort(403, 'The QR Sticker is InActive');
        }
        
        QrDetails::where('qr_code_id',$qr->id)->increment('page_views');
        $data['messages'] = Message::with('user')->get();
        $data['title'] = empty($data['qr_detail'])? request()->qr_code_id : $data['qr_detail']->user->name;
        return view('show_qr', $data);
    }

    public function showReseller()
    { 
        return view('reseller.create_form');
    }

    // kaleyra.com will hit this route function with call reports after call finsh..
    public function dlrUrl(Request $request)
    { 
        Log::info('DLR_URL CALLBACK DATA RECEIVED');
        $cl_id = Helper::decodeId($request->call_log_id);

        if($request->call_id == '{id}'){
            Log::error('Invalid DLR_URL');
            abort(404);
        }
        Log::info(json_encode($request->all()));
        
        CallLog::where('id', $cl_id)->update([
            'call_report' => json_encode($request->all())
        ]);

        $cl = CallLog::find($cl_id);
        $user = User::find($cl->to);

        $callWallet = $user->getWallet('call-wallet');
        $callWallet->withdrawFloat($cl->call_report->credits,[
            'call_id' => $cl_id,
            'message' => 'Wallet Balance Withdraw for call.'
        ]); 
        Log::info('Wallet Balance Withdraw for call #'.$cl_id);

        // Send Feedback to both users
        $this->sendFeedbackMail('call', $cl);

    }

    private function sendFeedbackMail($source, $call_log){
        $to = User::find($call_log->to);
        $from = User::find($call_log->from);

        Log::info('Sending Feedback Notification from Source Call');

        // send feedback to callee only when call is answered
        if($call_log->call_report->status == 'ANSWER')
            $to->notify(new CustomerFeedback($source));

        // send feedback to caller when initiate the call
        $from->notify(new CustomerFeedback($source));

    }

    public function showFaq()
    { 
        $faqs = [];
        $types = Faq::groupBy('type')->pluck('type')->toArray();
        foreach ($types as $value) {
            $faqs[$value] = Faq::where('type', $value)->get();
        }

        $data['faqs'] = $faqs;
        return view('pages.faq', $data);
    }

    public function showFeedback()
    { 
        return view('pages.feedback');
    }

    public function testSomethingHere(Request $request)
    { 
        if($request->secret != 321) abort(401);
        $datetime = \Carbon\Carbon::now()->subHours(1)->format("Y-m-d H:i");
        $orders = Order::where('status', 'Pending')->orWhere('status', 'Failed')
        ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d %H:%i'))"), '<=', $datetime)->limit(1)->get();
        foreach ($orders as $order) {
            Log::info('Sending emails to.'. $order->user->email);
            Mail::to($order->user->email)->queue(new IncompleteOrder($order));
        }
        dd('');
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://api.interakt.ai/v1/public/track/events/',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'POST',
        // CURLOPT_POSTFIELDS =>'{
        //     "phoneNumber": "8446458443",
        //     "countryCode": "+91",
        //     "event": "Sample Shipping",
        //     "traits": {
        //         "days": "20"
        //     },
        //     "createdAt": "2020-11-05T13:26:52.926Z"
        // }',
        // CURLOPT_HTTPHEADER => array(
        //     'Content-Type: application/json',
        //     'Authorization: Basic ZmNxN25nM0dHb1dFTThBQVFrekpTMFNTckRPVnNSZHlGTnVSR3ZyMk1DTTo='
        // ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // dd($response);
        // $last = CallLog::create(['to' => 1, 'from' => 2]);
        // $url = route('dlr_url').'?call_log_id='.Helper::encodeId($last->id).'&status=ANSWER&starttime=1624682764&endtime=1624682793&duration=29&call_id=8cd1d0c1-d0cd-4b23-aa67-590229214c75&ivr_id=NA&ring_time=25&credits=1.3202&billsec=8&call_type=Outgoing&callee=919309730048&caller=918446458443&bridge=912063116111';
        // return redirect($url);
        
    }

}
