<?php

namespace App\Http\Livewire\Account;

use App\Helpers\Helper;
use App\Models\QrDetails;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class OtpForm extends Component
{
    public $otp = null;
    public $previous = null;
    public function render(){
        return view('livewire.account.otp-form');
        
    }

    function rules() {

        return [
            'otp' => 'required|digits:6|exists:users,otp,phone,'.auth()->user()->phone,
        ];

    }

    protected $messages = [
        'otp.exists' => 'The otp you entered is invalid.',
    ];

    public function mount(){
        $this->previous = URL::previous();
    }

    public function verify(){

        $this->validate();

        $field = session('verification_type').'_verified_at';
        $user = User::find(auth()->user()->id);

        if($field == 'emergency_phone_verified_at'){
            $d = QrDetails::where('user_id', auth()->user()->id)->first();
            $d->$field = Carbon::now();
            $d->save();

        }else{
            $user->$field = Carbon::now();
            $user->save();

        }
        
        session()->forget(['verification_type', 'sent_to']);
        return redirect($this->previous);

    }

    public function send_otp($resend = false){
        
        if(!$resend)
            $this->validate();
        
        $user = User::find(auth()->user()->id);
        $user->otp = Helper::sendOtp(session('sent_to'));
        $user->save();
        $this->emit('alert', 'success', 'OTP Send Successfully');

    }
}
