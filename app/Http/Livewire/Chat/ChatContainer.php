<?php

namespace App\Http\Livewire\Chat;

use App\Helpers\Helper;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatContainer extends Component
{
    public $messages;
    public $receiver = null;
    public $isDelete = false;
    protected $listeners = [
        'fromUserList' => 'setChatUser',
        'refreshChatContainer' => '$refresh'
    ];

    public function mount($user_id)
    {
        $this->receiver = User::find(Helper::decodeId($user_id));
    }

    public function render()
    {
        return view('livewire.chat.chat-container');
    }

    public function setChatUser($receiver_id)
    {
        if($this->receiver == null || Helper::decodeId($receiver_id) != $this->receiver->id){
            $this->emit('urlChange', route('account.message', $receiver_id));
        
            $receiver_id = Helper::decodeId($receiver_id);
            $this->receiver = User::find($receiver_id);
            $this->emit('room-change', $receiver_id); // listen in app.blade Echo.private
            $this->emit('fromChatContainer', $receiver_id); // listen in chat-messages
            
        }
    }

    public function resetChat(){
        $this->receiver = null;
        $this->emit('room-change', null); // listen in app.blade Echo.private
        $this->emit('urlChange', route('account.message'));
    }

    public function deleteChat($receiver_id){
        $receiver_id = Helper::decodeId($receiver_id);
        $ar = array(Auth::id());
        $m = Message::where('sender_id', Auth::id())->where('receiver_id', $receiver_id)->first();
        if($m->is_deleted == null)
            $ar[] = $m->is_deleted;

        Message::where('sender_id', Auth::id())->where('receiver_id', $receiver_id)
        ->orWhere('receiver_id', Auth::id())->orWhere('sender_id', $receiver_id)->update(['is_deleted' => json_encode($ar)]);
        $this->emit('alert', 'success', 'Chat Deleted Successfully');
        $this->emitSelf('$refresh');
    }
}
                                                                           