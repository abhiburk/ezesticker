<?php

namespace App\Http\Livewire\Utils;

use App\Channels\SmsChannel;
use App\Notifications\ReferralInvitation as NotificationsReferralInvitation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ReferralInvitation extends Component
{
    public $referral_type = null;
    public $whatsapp_no = null;
    public $sms_no = null;
    public $email_id = '';

    public function render()
    {
        return view('livewire.utils.referral_invitation');
    }

    function rules(){

        return [
            'whatsapp_no' => $this->referral_type=='whatsapp' ? 'required|digits:10': 'nullable',
            'sms_no' => $this->referral_type=='sms' ? 'required|digits:10': 'nullable',
            'email_id' => $this->referral_type=='email' ? 'required|email': 'nullable',
        ];
        
    } 

    public function onReferralShare($referral_type)
    {
        $this->referral_type = $referral_type;

        $this->validate();
        $whatsapp_text = auth()->user()->name. ' invited you to join ezesticker.com. Use the referral code *'.auth()->user()->affiliate_id.'* and we will send you and your friend *'.REFERRAL_COMMISION.'%* comission 💰 in wallet when you purchase and verify ezesticker.';
        Log::info($referral_type);
        if($referral_type == 'whatsapp'){
            return redirect('https://api.whatsapp.com/send?phone=+91'.$this->whatsapp_no.'&text='.strip_tags($whatsapp_text));
        }
        if($referral_type == 'sms'){
            Notification::route(SmsChannel::class, $this->sms_no)->notify(new NotificationsReferralInvitation(auth()->user()));
            $this->emit('alert', 'success', 'SMS Invitation Sent Successfully..');
            $this->sms_no = null;
        }
        if($referral_type == 'email'){
            Notification::route('mail', $this->email_id)->notify(new NotificationsReferralInvitation(auth()->user()));
            $this->emit('alert', 'success', 'Email Invitation Sent Successfully.');
            $this->email_id = null;
        }
       
    }
}
