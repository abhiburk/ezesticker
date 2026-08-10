<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Wallet, WalletFloat
{
    use HasFactory, Notifiable, HasRoles, HasWalletFloat, Notifiable, HasWallet, HasWallets;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function qr_details()
    {
        return $this->hasMany(QrDetails::class, 'user_id');
    }

    /**
     * A user can have many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(){
        return $this->hasMany(Message::class, 'sender_id');
        
    }
    
    public function receive_messages(){
        return $this->hasMany(Message::class, 'receiver_id');
        
    }
    
    public function referral()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    public function call_logs()
    {
        return $this->hasMany(CallLog::class, 'to');
    }

    private function get_brightness($hex) { 
        // returns brightness value from 0 to 255 
        // strip off any leading # 
        $hex = str_replace('#', '', $hex); 
        $c_r = hexdec(substr($hex, 0, 2)); 
        $c_g = hexdec(substr($hex, 2, 2)); 
        $c_b = hexdec(substr($hex, 4, 2)); 
        
        return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
    }

    public function getUserImageUrl($avatar = null)
    {
        if(empty($avatar)) {
            $bg_color = $this->avtar_bg;;

            if ($this->get_brightness($bg_color) > 130) { // will have to experiment with this number 
                $textColor = '000000';
            } else {  
                $textColor = 'FFFFFF';
            }  
            
            return 'https://dummyimage.com/80x80/' . $bg_color . '/' . $textColor . '?text=' . substr($this->name, 0, 1);
        }else{
            Log::info('Avatar Available');
            return $avatar;
        }
    }

}
