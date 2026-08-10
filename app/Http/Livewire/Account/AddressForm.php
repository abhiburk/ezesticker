<?php

namespace App\Http\Livewire\Account;

use App\Helpers\Helper;
use App\Models\User;
use App\Models\UserAddress;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddressForm extends Component
{
    public $address = null;
    public $country = 'India';
    public $states = null;

    public $address_type = 'billing';
    public $is_shipping_different = false;

    protected $listeners = ['refreshComponent' => '$refresh'];
    
    function rules() {

        return [
            'address.name' => 'required',
            'address.email' => 'required|email',
            'address.address_line_1' => 'required',
            'address.address_line_2' => 'nullable',
            'address.phone' => 'required',
            'address.pincode' => 'required',
            'address.is_default' => 'nullable',
            'address.city' => 'required',
            // 'address.country' => 'nullable',
            'address.state' => 'required',
        ];
        
    }

    public function mount(){

        $address = $this->getAddress();
        $this->address = $address ? $address : new UserAddress();
        $this->states = $this->getStates();

        // for billing address read only fields...
        $this->address->name = auth()->user()->name;
        $this->address->phone = auth()->user()->phone;
 
     }

    public function render()
    {
        return view('livewire.account.address-form');
    }

    public function storeAddress(){

        $input = $this->validate();
        $input = $input['address'];
        
        try {
            
            $input['address_type'] = $this->address_type;

            UserAddress::updateOrCreate([
                'user_id' => auth()->user()->id,
                'address_type' => $this->address_type
            ], $input);

            // Update email id in User model
            $user = User::find(auth()->id());
            if(empty($user->email)){
                $user->email = $input['email'];
                $user->save();
            }

            $this->toggleAddress($this->address_type);
            $this->emit('refreshCheckoutComponent');
            $this->emit('alert', 'success', 'Address Updated!');

        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
        
    }

    private function getStates(){
        return  
                [ 
                    "Andhra Pradesh",
                    "Arunachal Pradesh",
                    "Assam",
                    "Bihar",
                    "Chhattisgarh",
                    "Goa",
                    "Gujarat",
                    "Haryana",
                    "Himachal Pradesh",
                    "Jammu and Kashmir",
                    "Jharkhand",
                    "Karnataka",
                    "Kerala",
                    "Madhya Pradesh",
                    "Maharashtra",
                    "Manipur",
                    "Meghalaya",
                    "Mizoram",
                    "Nagaland",
                    "Odisha",
                    "Punjab",
                    "Rajasthan",
                    "Sikkim",
                    "Tamil Nadu",
                    "Telangana",
                    "Tripura",
                    "Uttarakhand",
                    "Uttar Pradesh",
                    "West Bengal",
                    "Andaman and Nicobar Islands",
                    "Chandigarh",
                    "Dadra and Nagar Haveli",
                    "Daman and Diu",
                    "Delhi",
                    "Lakshadweep",
                    "Puducherry"
        ];
    }

    public function toggleAddress($type){

        $this->address_type = $type;
        $address = $this->getAddress();
        $this->address = $address ? $address : new UserAddress();

        $this->address->name = auth()->user()->name;
        $this->address->phone = auth()->user()->phone;

    }

    public function getAddress(){
        
        return UserAddress::where('user_id', auth()->user()->id)
        ->where('address_type', $this->address_type)->first();
    }

    public function setDefaultAddress(){
        
        UserAddress::where('user_id', auth()->user()->id)->update(['is_default' => 0]);

        $address =  UserAddress::where('user_id', auth()->user()->id)
                    ->where('address_type' , $this->address_type)->first();
        $address->is_default = 1;
        $address->save();

        // $this->emit('alert', 'success', 'Address Updated!');
        
    }
}
