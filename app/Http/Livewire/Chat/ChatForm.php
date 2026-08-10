<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatForm extends Component
{   
    public $message = '';
    public $receiver;
    public $sender;
    public $room;
    public $old_receiver_id = null; // to unsubscribe the channel when joining the new channel
    public $temp_msg_id = 0;
    protected $listeners = [
        'fromChatContainer' => 'setUserInChatForm'
    ];
    
    public function render()
    {
        return view('livewire.chat.chat-form');
    }

    public function mount($user_id)
    {
        $this->receiver = User::find($user_id);
        $this->sender = auth()->user();
    }
    
    public function rules(){
        return [
            'message' => 'required',
            'temp_msg_id' => 'nullable'
        ];
    }
    
    /**
     * Persist message to database
     *
     * @return Response
     */
    public function sendMessage(){
        $this->validate();
        $check_last_msg = Message::where('sender_id', Auth::id())->where('receiver_id', $this->receiver->id)->latest()->first();
        $message = $this->sender->messages()->create([
            'message' => $this->message,
            'receiver_id' => $this->receiver->id
        ]);

        // send notification when their is first msg or after one hr difference from last msg
        if($check_last_msg == null || (Carbon::now()->diffInMinutes($check_last_msg->created_at) >= 60)){
            $this->receiver->notify(new NewMessage($this->receiver, $message));
        }

        broadcast(new MessageSent($message))->toOthers();
        $this->message = '';
        $this->emit('message-sent', $this->temp_msg_id);
        $this->emit('scroll-to-bottom');
        $this->temp_msg_id += 1; // for msg seen fa-check and sent callback
        return ['status' => 'Message Sent!'];

    }

    public function setUserInChatForm($receiver_id){
        $receiver_id = $receiver_id;
        $this->receiver = User::find($receiver_id );
        $this->old_receiver_id = $receiver_id;

    }
    
}
