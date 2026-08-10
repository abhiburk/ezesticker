<?php

namespace App\Http\Livewire\Auth;

use App\Helpers\Helper;
use App\Jobs\MailJob;
use App\Models\Product;
use App\Models\QrCode;
use App\Models\QrDetails;
use App\Models\User;
use App\Models\UserAddress;
use App\Notifications\ReferralEarning;
use App\Notifications\Welcome;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LoginForm extends Component
{

    public $phone = null;
    public $name = null;
    public $otp = null;
    public $user = null;
    public $referral_code = null;

    public $show_otp_field = false;
    public $is_phone_valid = false;
    public $qr_code_id = null;
    public $is_phone_hidden = 1;
    public $show_referral = false;
    public $previous = null;
    public $login_source;
    protected $listeners = ['refreshComponent' => '$refresh'];

    protected function rules(){

        if($this->show_otp_field){

            return [
                'is_phone_hidden' => 'nullable',
                'name' => $this->user->phone_verified_at==null? 'required' : 'nullable',
                'otp' => 'required|digits:6|exists:users,otp,phone,'.$this->phone,
                // check if code exists and ignore self referral code as well
                'referral_code' => [
                    $this->show_referral? 'required' : 'nullable',
                    'exists:users,affiliate_id', function ($attribute, $value, $fail) {
                    // check case sensitive referral code
                    $check_code = User::whereRaw('BINARY affiliate_id = "'.$this->referral_code.'" ')->where('id', '!=', $this->user->id)->count();
                    if($check_code == 0) 
                        $fail('The referral code you entered is invalid.');
                }]
            ];

        }else{

            return [
                'phone' => 'required|size:10',
            ];

        }
        
    }

    protected $messages = [
        'phone.exists' => 'The phone number you entered does not exist.',
        'otp.exists' => 'The otp you entered is invalid.',
        'referral_code.exists' => 'The referral code you entered is invalid.',
    ];

    public function mount($qr_code_id = null, $login_source  = 'modal'){
        $this->qr_code_id = $qr_code_id;
        $this->previous = URL::previous();
        $this->login_source = $login_source;
        
        if(auth()->check()){
            $this->phone = auth()->user()->phone;
            $this->user = auth()->user();
        }
    }

    public function render(){

        if(strlen($this->phone) == 10){
            $this->is_phone_valid = true;
        }else{
            $this->is_phone_valid = false;
        }
        return view('livewire.auth.login-form');
        
    }

    public function login(){
        $this->validate();
 
        $user = User::where('phone', $this->phone)->first(); 
        
        $hashids = new Hashids('', 5); // pad to length 5
        $referral = $this->referral_code ? $hashids->decode($this->referral_code)[0] : null;
        if($user->phone_verified_at == null){
            $user->referred_by = $referral;
            $user->affiliate_id = $hashids->encode($user->id);

            $user->phone_verified_at = Carbon::now();
            $user->name = $this->name;
            $user->save();
            $user->notify(new Welcome()); // send a welcome sms to user.

            // save address with minimal details only when signing up
            $address = new UserAddress();
            $address->user_id = $user->id;
            $address->address_type = 'billing';
            $address->name = $user->name;
            $address->phone = $user->phone;
            $address->country = 'India';
            $address->save();
            
        }
        
        Auth::loginUsingId($user->id);
 
        // if registering the QR code for the first time
        if(Helper::decodeIdForQr($this->qr_code_id)&& QrDetails::where('qr_code_id', Helper::decodeIdForQr($this->qr_code_id))->doesntExist()){
            $qr = new QrDetails();
            $qr->qr_code_id = Helper::decodeIdForQr($this->qr_code_id);
            $qr->user_id = $user->id;
            $qr->call_service_expire_at = Carbon::now()->addYears(1);
            $qr->save();

            $d = QrCode::find(Helper::decodeIdForQr($this->qr_code_id));
            $qc = $d;
            $qc->qr_verified_at = Carbon::now();
            $qc->save();

            Log::info('Wallet Process Start');
            // get this qr code price
            $p = Product::where('slug', $d->type)->first();
            $price = $p->prices->first()->price;
            Log::info(Helper::decodeIdForQr($this->qr_code_id). ' QR Price found: '. $price);

            $beneficiary_by = User::where('id', $referral)->first();
            $beneficiary_to = $user;
            if($beneficiary_by != null){
               $this->setReferral($beneficiary_by, $beneficiary_to, $price);
            }
            
            return redirect()->route('account.qr_sticker.edit', $this->qr_code_id);
        
        // if qr is scanned and user is registering before making a call
        }elseif(Helper::decodeIdForQr($this->qr_code_id)){
            return redirect()->route('qr.show_details', $this->qr_code_id);
        }else{
            return redirect($this->previous);
        }
    }

    public function sendOtp($resend = false){
        $is_new = false;
        if(!$resend)
            $this->validate();

        $user = User::where('phone', $this->phone)->first();
        if($this->login_source == 'reseller' && $user->hasRole('Reseller')){
            $this->emit('alert', 'error', 'You are already with reseller account. Please login to access your account.'); return;
        }
        // if not register create user first
        if($user == null){
            $is_new = true;
            $user = new User();
            $user->phone = $this->phone;  
            $user->avtar_bg = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
            $user->assignRole('Customer'); 
        }
        if($this->login_source == 'reseller')
            $user->assignRole('Reseller');

        $user->otp = Helper::sendOtp($this->phone);
        $user->save(); 

        if($is_new){ 

            // create a new wallet for new user
            if(!$user->hasWallet('my-wallet')){
                $wallet = $user->createWallet([
                    'name' => 'Call Wallet',
                    'slug' => 'call-wallet',
                ]);
                $wallet->depositFloat(CALL_WALLET_DEPOSIT_AMT, [
                    'message' => 'Free Signup Credits'
                ]);
            }
        } 
        $this->user = $user;
        $this->show_otp_field = true;

    }

    public function backToLogin(){
        $this->show_otp_field = false;
        $this->phone = null;
        $this->emit('refreshComponent');
        
    }

    public function showReferral(){
        $this->show_referral = !$this->show_referral;
        
    }

    private function setReferral($beneficiary_by, $beneficiary_to, $price){
        Log::info('Beneficiary ID: '. $beneficiary_by->id);
        // transefer commision to beneficiary to wallet
        $commision = (REFERRAL_COMMISION/100)*$price;
        Log::info('Commision Calculated');
        
        // add money to the user whos referral code is used
        $beneficiary_by->depositFloat($commision, [
            'created_by' => $beneficiary_to->id,
            'qr_code_id' => Helper::decodeIdForQr($this->qr_code_id),
            'message' => 'Referral Commission Deposited'
        ]);

        // add money to the user who is using referral code in qr verification
        $beneficiary_to->depositFloat($commision, [
            'created_by' => $beneficiary_by->id,
            'qr_code_id' => Helper::decodeIdForQr($this->qr_code_id),
            'message' => 'Referral Commission Deposited'
        ]);
        
        // send email to the person who was referred. SELF
        $beneficiary_to->notify(new ReferralEarning('receiver', $beneficiary_to));
        // send email to the person who referred his friend. FRIEND
        $beneficiary_by->notify(new ReferralEarning('sender', $beneficiary_to));
       
        Log::info('Beneficiary deposited to '.$beneficiary_to->name.' and '.$beneficiary_by->name.' with: '.$commision);
    }

}
