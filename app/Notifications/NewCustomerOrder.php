<?php

namespace App\Notifications;

use App\Channels\Messages\SmsMessage;
use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCustomerOrder extends Notification implements ShouldQueue
{
    use Queueable;
    public $order = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
                ->subject("New Order Received #".$this->order->id)
                ->markdown(
                    'emails.new_customer_order', [
                        'order' => $this->order
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
            ->content("We have received your #".$this->order->id." order. We will process your order soon. Click the link to view order.")
            ->dlt_id('1307161718271490913')
            ->url(route('account.order.show', $this->order->id));
    }
}
