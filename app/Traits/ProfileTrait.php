<?php
namespace App\Traits;
use App\Helpers\Helper;
use App\Models\User;

trait ProfileTrait
{

    public function send_otp_at($email, $field = 'phone'){
        $user = User::find(auth()->user()->id);
        $user->otp = Helper::sendOtp($email);
        $user->save();
        session([
            'verification_type'=> $field, 
            'sent_to' => $email,
        ]);
        redirect()->route('account.verification');
    }

}