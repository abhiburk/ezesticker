<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;
    public function render()
    {
        $data['orders'] = Auth::user()->orders()->latest()->simplePaginate(10);
        return view('livewire.account.order-list', $data);
    }
}
