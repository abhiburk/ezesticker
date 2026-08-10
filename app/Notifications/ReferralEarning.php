<?php

namespace App\Notifications;

use App\Channels\Messages\SmsMessage;
use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralEarning extends Notification implements ShouldQueue
{
    use Queueable;
    public $content = '';
    public $user;
    public $source;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($source, $user)
    {
        $this->user = $user;
        $this->source = $source;
        if ($source == 'sender')
            $this->content .= $this->user->name .' successfully purchased and verified ezesticker after getting your referral code.';
        else 
            $this->content .= 'Congratulations you have successfully linked your ezesticker with your mobile number through your friends referral code.';
        $this->content .= " To Thank you, we've awarded you ".REFERRAL_COMMISION."% commission in your wallet.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {   
        $channel = [];
        if(isset($notifiable->email) && $notifiable->email != null && $notifiable->email_verified_at != null)
            $channel[] = 'mail';
        
        if(env('APP_ENV') == 'production')
            $channel[] = SmsChannel::class;
        return $channel;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject("Referral Earning Received")
                ->markdown(
                    'emails.referral_earning', [
                        'beneficiary' => $notifiable,
                        'name' => $this->user->name,
                        'source' => $this->source
                    ]
                );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toSms($notifiable)
    {
        $dlt_id = $this->source == 'sender' ? '1307161718316431680': '1307161718326036008';
        return (new SmsMessage())
            ->content($this->content)
            ->url(route('account.wallet'))
            ->dlt_id($dlt_id);
    }
}
