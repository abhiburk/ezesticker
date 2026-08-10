<?php

namespace App\Http\Livewire\Chat;

use App\Helpers\Helper;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ChatMessages extends Component
{
    public $perPage = 10;
    public $totalMessages = 0;
    public $sender;
    public $receiver;
    protected $listeners = [
        'refresMessagesComponent' => '$refresh',
        'fromChatContainer' => 'getUserMessages'
    ];

    public function mount($user_id){
        $this->receiver = User::find($user_id);
        $this->sender = auth()->user();
    }
    
    private function msgQuery($receiver_id){
        return Message::whereJsonDoesntContain('is_deleted', Auth::id())
        ->where(function($query) use($receiver_id){
            $query->where(function($query) use($receiver_id){
                $query->where('sender_id', Auth::id())->where('receiver_id', ($receiver_id));
            })->orwhere(function($query) use($receiver_id){
                $query->where('sender_id', ($receiver_id))->where('receiver_id', Auth::id());
            });
        });
    }

    public function render(){
        $receiver_id = $this->receiver->id;
        $this->totalMessages = $this->msgQuery($receiver_id)->count();
        Message::where('sender_id', $receiver_id)->where('receiver_id', Auth::id())->update(['read_at' => Carbon::now()]);
        $data['messages'] = $this->msgQuery($receiver_id)->latest()->paginate($this->perPage)->reverse();
        return view('livewire.chat.chat-messages', $data);
    }

    public function loadMore($perPage)
    {
        $this->perPage = $perPage;
    }

    public function getUserMessages($receiver_id){
        $this->receiver = User::find($receiver_id);
        // mark msgs as read on clicking user
        Message::where('sender_id', $receiver_id)->where('receiver_id', Auth::id())->update(['read_at' => Carbon::now()]);
        $this->emitSelf('$refresh');
        $this->emit('scroll-to-bottom');
    }
}
