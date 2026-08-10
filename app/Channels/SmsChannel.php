<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use RobinCSamuel\LaravelMsg91\Facades\LaravelMsg91;
use Shivella\Bitly\Facade\Bitly;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        $content = strip_tags($message->content); //remove html tags
        if($message->url != ''){ //check if link is to be sent
            // $content = $content.' Link:- '.$message->url;
            if($message->url != ''){ //check if link is to be sent
                $short_link = strpos($message->url , 'bit.ly') !== false ? $message->url : Bitly::getUrl($message->url); //check if url is already bit.ly
                $content = $content.' Link: '.$short_link;
            }
        }

        $phone = $message->alter_phone != '' ? $message->alter_phone : (isset($notifiable->phone) ? $notifiable->phone : $notifiable->routes[SmsChannel::class]);
        // Send notification to the $notifiable instance...
        Log::info($phone .'-'. $content.'-'.$message->dlt_id.'-'.$message->dev_mode);
        $result = LaravelMsg91::message($phone, $content, ['DLT_TE_ID' => $message->dlt_id, 'dev_mode' => $message->dev_mode]);
        Log::info(json_encode($result));
        if($result->type =='error'){
            Log::warning(' Message not delivered. Number-'.$phone.' Message:'.$content);
        }
    }
}
