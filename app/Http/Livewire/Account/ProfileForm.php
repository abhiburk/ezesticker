<?php

namespace App\Http\Livewire\Account;

use App\Models\QrDetails;
use App\Models\User;
use App\Traits\ProfileTrait;
use Livewire\Component;

class ProfileForm extends Component
{
    use ProfileTrait;

    public $user;
    protected $listeners = ['refreshComponent' => '$refresh'];

    function rules() {

        return [
            'user.name' => 'required',
            'user.email' => 'nullable|email|unique:users,email,'.$this->user->id,
            'user.phone' => 'nullable|digits:10|unique:users,phone,'.$this->user->id,
        ];
        
    }
    
    public function mount(){

       $this->user = auth()->user();

    }

    public function render(){

        return view('livewire.account.profile-form');

    }

    public function profile(){

        $this->validate();
        $user = User::find(auth()->user()->id);

        // if phone or email updated empty the email and phone verified at to null
        if($user->phone != $this->user->phone){
            session(['verification_type'=> 'phone', 'sent_to' => $this->user->phone ]);
            $user->phone_verified_at = null;
        }

        if($user->email != $this->user->email){
            session(['verification_type'=> 'email', 'sent_to' => $this->user->email ]);
            $user->email_verified_at = null;
        }

        $user->name = $this->user->name;
        $user->email = $this->user->email;
        $user->phone = $this->user->phone;
        $user->save();

        $this->emit('alert', 'success', 'Profile Details Updated');
        $this->emit('refreshComponent');
        
        if($user->phone_verified_at == null)
            redirect()->route('account.verification');

    }
 
}
