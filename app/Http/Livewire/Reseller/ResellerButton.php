<?php

namespace App\Http\Livewire\Reseller;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ResellerButton extends Component
{
    public function render()
    {
        return view('livewire.reseller.reseller-button');
    }

    public function becomeSeller(){
        $user = Auth::user();
        $user->assignRole('Reseller');

        $this->emit('alert', 'success', 'Your account is now a reseller account.');
        $this->emitSelf('$refresh');
    }
}
