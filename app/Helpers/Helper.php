<?php

namespace App\Helpers;

use App\Jobs\MailJob;
use App\Models\Product;
use App\Models\QrCode;
use App\Models\QrDetails;
use App\Models\SiteOption;
use App\Models\User;
use App\Notifications\Otp;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RobinCSamuel\LaravelMsg91\Facades\LaravelMsg91;

class Helper {
    
    public static function firstLetter($str){
        $acronym = '';
        $word = '';
        $words = preg_split("/(\s|\-|\.)/", $str);
        $count = 0;
        foreach($words as $i => $w) {
            if($i <= 1){
                $acronym .= substr($w,0,1);
            }
        }
        $word = $word . $acronym ;
        return $word;
    }

    public static function getProfileRoute(){

        $credit = INR.' '.auth()->user()->getWallet('call-wallet')->balanceFloat ?? '0';
        return [
            ['route' => 'dashboard', 'icon' => 'bi-list-task', 'label' => 'Dashboard'],
            ['route' => 'profile', 'icon' => 'bi-person-badge', 'label' => 'Profile'],
            ['route' => 'address', 'icon' => 'bi-geo-alt', 'label' => 'Address'],
            ['route' => 'order', 'icon' => 'bi-bag', 'label' => 'My Orders'],
            ['route' => 'qr-sticker', 'icon' => 'bi-upc-scan', 'label' => 'My QR Stickers'],
            ['route' => 'wallet', 'icon' => 'bi-wallet2', 'label' => 'My Wallet'],
            ['route' => 'call-logs', 'icon' => 'bi-telephone', 'label' => 'Call Logs ('.$credit.')'],
        ];
    }

    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public static function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected static function getRelatedSlugs($slug, $id = 0){
        return Product::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->where('slug', '!=', $slug)
            ->get();
    }

    public static function sendOtp($phone, $message = null, $otp = null){
        $otp = $otp ? $otp : (env('APP_ENV') == "production"? mt_rand(100000, 999999) : 123456);
        
        if(is_numeric($phone)){
            $message = $message ? $message : 'Please use the verification code '.$otp.' to confirm your identity for '.env('APP_NAME');
            
            // $message = $message ? $message : 'Please use the verification code to confirm your identity for '.env('APP_NAME').'. '. $otp;
            $fake = new \stdClass();
            $fake->message = "39616b6e486b323335353437";
            $fake->type = "success";

            $res = env('APP_ENV') == "production" ? LaravelMsg91::message($phone, $message, ['DLT_TE_ID' => '1307162393865253354']) : $fake;
            Log::info(json_encode($res));

        }else{

            $user = User::where('email', $phone)->first();
            $user->notify(new Otp($otp));
                        
        }

        return $otp;
    }

    public static function orderStatus($type = null){
        $statuses = [
            array('name' => 'Pending', 'value' => 'Pending'),
            array('name' => 'Failed', 'value' => 'Failed'),
            array('name' => 'Processing', 'value' => 'Processing'),
            array('name' => 'Completed', 'value' => 'Completed'),
            array('name' => 'On hold', 'value' => 'On hold'),
            array('name' => 'Canceled', 'value' => 'Canceled'),
            array('name' => 'Refunded', 'value' => 'Refunded'),
        ];
        if($type == 'object') return json_decode(json_encode($statuses));
        return $statuses;
    }

    public static function stockStatus($type = null){
        $statuses = [
            array('name' => 'In Stock', 'value' => 'In Stock', 'bg_color' => 'bg-success'),
            array('name' => 'Out of Stock', 'value' => 'Out of Stock', 'bg_color' => 'bg-danger'),
        ];
        if($type == 'object') return json_decode(json_encode($statuses));
        return $statuses;
    }

    public static function upload($files, $model, $folder){
        
        if(!empty($files)){

            // if file is not multiple make $files as an laravel array collection
            if(!is_array($files))
                $files = collect([$files]);

            foreach ($files as $file) {
                $fname = Str::random(10).'_'.$file->getClientOriginalName();
                $model->media()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $folder.'/'.$fname,
                    'type' => $file->getMimeType(),
                ]);
                $file->storeAs('public/'.$folder, $fname);
            }

        }

    }

    public static function encodeIdForQr($val){
        return Hashids::connection('alternative')->encode($val);
    }

    public static function decodeIdForQr($val){ 
        if(isset(Hashids::connection('alternative')->decode($val)[0])){
            return Hashids::connection('alternative')->decode($val)[0];
        }
    }

    public static function encodeId($val){
        return Hashids::encode($val); 
    }

    public static function decodeId($val){
        if(isset(Hashids::decode($val)[0]))
            return Hashids::decode($val)[0]; 
    }

    public static function throwExeception($ex){
        Log::error($ex->getMessage());
        if (app()->env == 'production') {
            //nothing
        } else {
            dd($ex);
        }
        // $error['message'] = 'Something went wrong! Please try again later.';
        // return response()->json(['error' => $error]);
        return redirect()->back()->with('error', 'Something went wrong! Please try again later.'); 
    }

    // function to verify form through google reCaptcha
    public static function reCaptcha($recaptcha){
        $secret = "6LeGIgkaAAAAAMdyrc4TBIEat97Hgt26_KGWfzg7";
        $ip = $_SERVER['REMOTE_ADDR'];
      
        $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        $data = curl_exec($ch);
        curl_close($ch);
      
        return json_decode($data, true);
    }

    public static function formatSize($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function getDummyQr(){
        
        $id = QrDetails::whereHas('user', function ($query) {
            return $query->where('phone', '=', 8446458443);
        })->first()->qr_code_id;

        return static::encodeId($id);
    }

    public static function getCallTopUps(){
        return [
            50, 100, 150, 200, 500, 1000
        ];
    }

    public static function getFaqTypes(){
        return [
            'Product',
            'Shipping',
            'Return & Refund'
        ];
    }

}