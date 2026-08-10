<?php

namespace App\Http\Livewire\Chat;

use App\Helpers\Helper;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChatUserList extends Component
{
    public $receiver;
    public $search;

    protected $listeners = [
        'fromUserList' => 'setChatUser',
        'refreshChatList' => '$refresh'
    ];

    public function render()
    {
        $data['users'] = 
        User::select('users.*')
        ->addSelect(DB::raw('(select count(*) from messages im where im.read_at IS NULL and im.receiver_id='.Auth::id().' and im.sender_id=users.id) as unread'))
        ->addSelect(DB::raw('(select message from messages where (messages.sender_id=users.id or messages.receiver_id=users.id) order by messages.id desc limit 1) as latest_msg'))
        ->rightJoin('messages', function($join) {
            $join->on('messages.sender_id','=','users.id');
            $join->orOn('messages.receiver_id','=','users.id');
        })
        ->where(function ($query) {
            $query->where('messages.sender_id', '=', Auth::id())
                  ->orWhere('messages.receiver_id', '=', Auth::id());
        })
        ->where('users.id', '!=', Auth::id())
        ->where('users.name','like', '%'.$this->search.'%')
        ->whereRaw("NOT JSON_CONTAINS(is_deleted, ".Auth::id().")")
        ->groupBy('users.id')
        ->orderBy('messages.id', 'DESC')
        ->get();
        
        return view('livewire.chat.chat-user-list', $data);
    }

    public function mount($user_id)
    {
        $this->receiver = User::find(Helper::decodeId($user_id));
    }

    public function setChatUser($receiver_id)
    {
        $this->receiver = User::find(Helper::decodeId($receiver_id));
    }

}
