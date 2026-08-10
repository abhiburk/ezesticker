<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class QrList extends Component
{
    use WithPagination;
    public function render()
    {
        $user = User::find(auth()->user()->id);
        $data['qr_details'] = $user->qr_details()->simplePaginate(10);
        return view('livewire.account.qr-list', $data);
    }
}
