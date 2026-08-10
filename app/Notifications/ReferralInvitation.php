<?php

namespace App\Notifications;

use App\Channels\Messages\SmsMessage;
use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralInvitation extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // check route channel comming from App\Http\Livewire\Utils\ReferralInvitaion
        if(isset($notifiable->routes[SmsChannel::class]) && env('APP_ENV') == 'production')
            return [SmsChannel::class];
        if(isset($notifiable->routes['mail']))
            return ['mail'];
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
                ->subject("Referral Invitation")
                ->markdown(
                    'emails.referral_invitation', ['user' => $this->user]
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
        $content = $this->user->name." invited you to join ezesticker. Use the referral code ".$this->user->affiliate_id." and we will send you and your friend ".REFERRAL_COMMISION."% commission in wallet when you purchase and verify ezesticker.";
        return (new SmsMessage())
            ->content($content)
            ->url(route('login'))
            ->dlt_id('1307161718347813718');
    }
}
