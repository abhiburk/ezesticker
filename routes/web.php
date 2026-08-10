<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\UserController;
use App\Notifications\CustomerFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// this route is created to make tests for any code
// pass 321 to parm to access the route
Route::get('run/test/{secret}', [HomeController::class, 'testSomethingHere'])->middleware('auth');

// callback URL for kaleyra DLRURL https://developers.kaleyra.io/docs/dynamic-variable-for-dlrurl
Route::get('manage/call', [HomeController::class, 'dlrUrl'])->name('dlr_url');

Route::view('/', 'home')->name('home');
Route::get('page/{slug}', [PageController::class, 'show'])->name('page.show');
Route::get('qr/{qr_code_id}', [HomeController::class, 'showQrDetails'])->name('qr.show_details');
Route::view('/how-it-works', 'pages.how_it_works')->name('how-it-works');
Route::get('/faq', [HomeController::class, 'showFaq'])->name('faq');
Route::get('/feedback', [HomeController::class, 'showFeedback'])->name('feedback');

Route::group([ 'prefix' => 'shop' ], function() {
    Route::get('{slug}', [HomeController::class, 'showProduct'])->name('shop.slug');
    Route::get('', [HomeController::class, 'showShop'])->name('shop');
});

Route::get('cart', [HomeController::class, 'showCart'])->name('shop.cart');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'password.confirm' => false
]);
Route::get('reseller/create', [HomeController::class, 'showReseller'])->name('reseller.create');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::group([ 'middleware' => 'admin' , 'prefix' => 'admin' ], function() {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard'); 
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::post('product/image', [ProductController::class, 'storeImage'])->name('product.store_image');
        Route::post('product/price', [ProductController::class, 'storePrice'])->name('product.store_price');
        Route::delete('product/price/{price}', [ProductController::class, 'destroyPrice'])->name('product.delete_price');
        Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
        Route::resource('qrcode', QrCodeController::class);
        Route::post('qrcode/archive', [QrCodeController::class, 'archive'])->name('qrcode.archive');
        Route::resource('order', OrderController::class);
        Route::resource('page', PageController::class)->except(['show']);
        Route::resource('coupon', CouponController::class)->except(['show']);
        Route::resource('faq', FaqController::class)->except(['show']);

    });
    
    Route::group([ 'prefix' => 'account' ], function() {
        
        Route::middleware(['phone_verified'])->group(function () {
            Route::get('dashboard', [ProfileController::class, 'dashboard'])->name('account.dashboard');
            Route::get('profile', [ProfileController::class, 'index'])->name('account.profile');
            Route::get('address', [ProfileController::class, 'address'])->name('account.address');
            Route::get('order', [ProfileController::class, 'order'])->name('account.order');
            Route::get('order/{order}/{status?}', [ProfileController::class, 'showOrder'])->name('account.order.show');
            Route::get('qr-sticker', [ProfileController::class, 'qrSticker'])->name('account.qr-sticker');
            Route::get('qr-sticker/{qr_id}/edit', [ProfileController::class, 'editQrSticker'])->name('account.qr_sticker.edit');
            Route::get('call-logs', [ProfileController::class, 'showCallLogs'])->name('account.call-logs');
            Route::get('call-logs/credit', [ProfileController::class, 'showCredit'])->name('account.call-logs.credit');
            Route::get('wallet', [ProfileController::class, 'wallet'])->name('account.wallet');
            Route::view('messages/{user_id?}/{qr_code_id?}', 'account.messages')->name('account.message');
        });

        Route::get('verification', [ProfileController::class, 'verification'])->name('account.verification');
        
    });
    
    Route::middleware(['phone_verified'])->group(function () {
        Route::get('checkout', [HomeController::class, 'showCheckout'])->name('shop.checkout');
        Route::get('paytm/payment/{order}', [PaymentController::class, 'makePaytmPayment'])->name('paytm.make_payment');
        Route::post('paytm/response', [PaymentController::class, 'paytmPaymentResponse'])->name('paytm.response');
        Route::post('razorpay/response', [PaymentController::class, 'razorpayPaymentResponse'])->name('razorpay.response');
    });
    
    Route::view('/referral-program', 'pages.referral_program')->name('referral-program');
    

});

Route::get('/mailable', function () {
    $user = App\Models\User::find(1);

    return  $user->notify(new CustomerFeedback('call'));
    return (new CustomerFeedback('call'))
                ->toMail($user);
});

