<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CallLogs extends Component
{

    public function render()
    {
        $user = User::find(auth()->user()->id);
        $data['call_logs'] = $user->call_logs()->simplePaginate(10);
        return view('livewire.account.call-logs', $data);
    }
}
