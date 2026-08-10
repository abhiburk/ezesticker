<?php

namespace App\Http\Livewire\Chat;

use App\Events\UserOffline;
use App\Events\UserOnline;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ChatHeaderNotification extends Component
{

    protected $listeners = [
        'onlineStatus',
        'offlineStatus',
        'refreshChatHeaderNotification' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.chat.chat-header-notification');
    }

    public function onlineStatus($user){
        // $this->emit('alert', 'success', $user['name'] .' is Online');
        broadcast(new UserOnline(Auth::user()));
        $expireTime = Carbon::now()->addMinute(1); // keep online for 1 min
        Cache::put('is_online'.$user['id'], true, $expireTime);
        //Last Seen
        User::where('id', $user['id'])->update(['last_seen' => Carbon::now()]);
        $this->emit('refreshChatList');
        if(empty($this->receiver))
            $this->emit('refreshChatContainer');
    }

    public function offlineStatus($user){
        // $this->emit('alert', 'success', $user['name'] .' is Offline');
        broadcast(new UserOffline(Auth::user()));
        Cache::forget('is_online'.$user['id']);
        User::where('id', $user['id'])->update(['last_seen' => Carbon::now()]);
        $this->emit('refreshChatList');
        if(empty($this->receiver))
            $this->emit('refreshChatContainer');
    }
}
