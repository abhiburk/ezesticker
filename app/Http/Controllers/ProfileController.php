<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Order;
use App\Models\QrDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(){ 
        return view('account.profile');
    }

    public function dashboard(){
        
        return view('account.dashboard');
    }

    public function verification(){
        if(empty(session('verification_type'))){
            abort(403);
        }
        return view('account.verification');
    }

    public function address(){
        
        return view('account.address');
    }

    public function order(){ 
        return view('account.order');
    }

    public function showOrder(Order $order){

        if($order->user_id != auth()->user()->id) abort(401);
        
        $data['wallet_usage'] = DB::table('wallet_transactions')->whereRaw('JSON_EXTRACT(meta, "$.order_id") = '.$order->id)->first(); 
        $data['order'] = $order;
        return view('account.single_order', $data);
        
    }

    public function qrSticker(){

        return view('account.qr_sticker');
        
    }

    public function editQrSticker($qr_id){
        
        $data['qr_detail'] = QrDetails::where('qr_code_id', Helper::decodeIdForQr($qr_id))->first();
        if(empty($data['qr_detail'])) abort(404);
        
        if(auth()->user()->id != $data['qr_detail']->user_id) abort(401);
        return view('account.edit_qr_sticker', $data);
        
    }

    public function wallet(){ 
        $wallet = auth()->user()->wallet;
        $data['transactions'] = $wallet->transactions()->where('wallet_id', $wallet->id)->latest()->paginate(10);
        return view('account.wallet', $data);
    }

    public function showCallLogs(){
        // foreach (User::all() as $user) {
        //     $wallet = $user->createWallet([
        //         'name' => 'Call Wallet',
        //         'slug' => 'call-wallet',
        //     ]);
        //     $wallet->depositFloat(CALL_WALLET_DEPOSIT_AMT);
        // }
        return view('account.call_logs');
    }

    public function showCredit(){
        
        return view('account.call_credit');
    }
}
