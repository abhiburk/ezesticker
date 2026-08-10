<?php

namespace App\Notifications;

use App\Channels\Messages\SmsMessage;
use App\Channels\SmsChannel;
use App\Helpers\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification implements ShouldQueue
{
    use Queueable;
    public $to;
    public $message;
    public $from;
    public $alter_phone;
    public $source;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($to, $message, $alter_phone = '', $source = '')
    {
        $this->to = $to;
        $this->message = $message;
        $this->from = auth()->user();
        $this->alter_phone = $alter_phone;
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
                ->subject("You have a new message")
                ->markdown(
                    'emails.new_message', [
                        'to' => $this->to,
                        'message' => $this->message,
                        'from' => $this->from
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
            ->alter_phone($this->alter_phone)
            ->content("You have a new message on ezesticker from ".$this->from->name.". Click the below link to view.")
            ->dlt_id('1307162382546152865')
            ->url(route('account.message', [Helper::encodeId($this->from->id), Helper::encodeIdForQr($this->source) ]));
    }
}
