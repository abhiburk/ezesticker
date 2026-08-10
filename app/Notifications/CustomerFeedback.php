<?php

namespace App\Notifications;

use App\Channels\Messages\SmsMessage;
use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerFeedback extends Notification implements ShouldQueue
{
    use Queueable;
    public $source;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        $channel = ['mail'];
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
                ->subject("Rate Your Experience")
                ->markdown(
                    'emails.rate_your_experience',
                    [
                        'source' => $this->source,
                        'user' => $notifiable
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
        return (new SmsMessage())
            ->content("Please rate your experience about how do you feel using ezesticker service. Click the link below to submit your feedback.")
            ->dlt_id('1307162573907185030')
            ->url(route('feedback').'?source='.$this->source);
    }
}
