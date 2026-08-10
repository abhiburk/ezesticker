<?php

namespace App\Http\Livewire\Account;

use App\Helpers\Helper;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\QrDetails;
use App\Models\User;
use App\Traits\ProfileTrait;
use App\Traits\WalletTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Razorpay\Api\Api;
use Cart;

class QrForm extends Component
{
    use ProfileTrait, WalletTrait;

    public $qr_detail = null;
    public $emergency_phone = null;
    public $message_len = null;

    public $recharge_product = null;
    public $use_wallet = 0;
    public $wallet_balance = 0;
    public $wallet_balance_used = 0;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($qr_detail)
    {
        $this->wallet_balance = auth()->user()->wallet->balanceFloat;
        $this->recharge_product = Product::where('slug', 'smart-sticker-recharge')->first();

        $this->qr_detail = $qr_detail;
        $this->emergency_phone = isset($qr_detail->emergency_phone)?$qr_detail->emergency_phone:null;
    }

    function rules() {

        return [
            'qr_detail.emergency_phone' => [
                'nullable', 
                'digits:10',
                'nullable:qr_details,emergency_phone', function ($attribute, $value, $fail) {
                $check_code = User::where('phone', $this->qr_detail->emergency_phone)->where('id', auth()->user()->id)->count();
                if($check_code > 0) 
                    $fail('Emergency contact must be different from your registered mobile no.');
            }],
            'qr_detail.message' => 'required|max:255',
            'qr_detail.status' => 'required',
            'qr_detail.blood_group' => 'nullable',
            'qr_detail.qr_usage' => 'nullable',
            'qr_detail.is_emergency_phone_hidden' => 'nullable',
            'qr_detail.call_status' => 'required',
        ];
        
    }

    protected $messages = [
        // 'qr_detail.emergency_phone.required' => 'The emergency number field is required.',
        'qr_detail.emergency_phone.digits' => 'The emergency number must be of 10 digits.',
        'qr_detail.message.required' => 'The message field is required.',
        'qr_detail.message.max' => 'You can enter maximun 255 characters only.',
        'qr_detail.status.required' => 'The status field is required.',
    ];
    
    public function render()
    {
        return view('livewire.account.qr-form');
    }

    public function store(){

        $this->validate();

        $qr = $this->qr_detail;

        // if updating phone no. reset verify field
        // if($this->emergency_phone != $qr->emergency_phone){
        //     $qr->emergency_phone_verified_at = null;
        // }
        $qr->emergency_phone_verified_at = Carbon::now();
        $qr->emergency_phone = $this->qr_detail->emergency_phone;
        $qr->message = $this->qr_detail->message;
        $qr->save();

        $this->emit('refreshComponent');
        $this->emit('alert', 'success', 'QR Details Saved Successfully');

    }
}
