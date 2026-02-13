<?php

use App\Livewire\Auth\Login;
use App\Livewire\Site\Partial\Error;
use App\Livewire\Site\Product\ProductPage;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Site\Home\SiteIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Site\Partial\Thankyou;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Auth\Register;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\User\UserController;
use App\Livewire\Auth\User\UserForgetPassword;
use App\Http\Controllers\Basic\BasicController;
use App\Livewire\Site\Pages\CustomPagesComponent;
use App\Http\Controllers\Basic\LocationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Livewire\Site\ContactPage;
use App\Livewire\Site\ArticleDetail;
use App\Livewire\Site\ArticlesList;
use App\Livewire\Site\Cart\CartPage;
use App\Livewire\Site\Checkout\CheckoutPage;
use App\Livewire\Site\DoctorsDesk;
use App\Livewire\Site\Order\OrderSuccess;
use App\Livewire\Site\Orders\OrdersPage;
use App\Livewire\Site\Product\ProductView;
use App\Livewire\Site\ScienceBacked;
use App\Livewire\Site\ScienceOfHealth;
use App\Livewire\Site\GuidedPurchase;
use App\Livewire\Site\Faq;

Route::get('/cache_clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
});
Route::get('/', SiteIndex::class)->name('site.index');
Route::get('/articles', ArticlesList::class)->name('site.education');
Route::get('/articles/{slug}', ArticleDetail::class)->name('articles.show');
Route::get('/order/success/{order}', OrderSuccess::class)->name('order.success');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('/products', ProductPage::class)->name('site.products');
Route::get('/product/{slug}', ProductView::class)->name('site.product');
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register');
Route::get('/forget-password', UserForgetPassword::class)->name('forget.password');
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/contact-us', ContactPage::class)->name('contact-us');

 Route::get('/orders', OrdersPage::class)->name('orders.index');
Route::post('/payment/create-order', [PaymentController::class, 'createOrder'])->name('payment.create-order');
Route::post('/payment/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook'])->name('payment.webhook');

Route::get('/page/{slug}', CustomPagesComponent::class)->name('custom.pages');
Route::get('/thank-you', Thankyou::class)->name('thankyou');
Route::get('/404', Error::class)->name('error');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [BasicController::class, 'toLogout'])->name('logout');
});

Route::get('/logout', function () {

    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    Auth::guard('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');

})->name('logout');


Route::group(['middleware' => ['auth:web', 'user.active'],  'as' => 'user.'], function () {
    Route::get('/dashboard', [UserController::class, 'toUserDashboard'])->name('dashboard');
    Route::get('profile', [UserController::class, 'UserProfile'])->name('profile');
    Route::put('profile', [UserController::class, 'UserProfileUpdate'])->name('profileupdate');
    Route::get('user/orders', [UserController::class, 'orders'])->name('orders');
    Route::get('user/products', [UserController::class, 'Products'])->name('product');
    Route::post('/cart/add', [UserController::class, 'addCart'])->name('cart.add');
    Route::get('/cart/validate', [CartController::class, 'validateCart']);
 Route::put('/profile/update', [UserController::class, 'profileUpdate'])->name('profileupdate');
    Route::post('/kyc/update', [UserController::class, 'kycUpdate'])->name('kyc.update');
    Route::post('/password/update', [UserController::class, 'passwordUpdate'])->name('password.update');
    Route::post('/bank/update', [UserController::class, 'bankUpdate'])->name('bank.update');
    Route::get('user/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    // Checkout routes
    Route::get('user/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    // Checkout route
    Route::get('/invoice/{id}', [UserController::class, 'downloadInvoice'])
         ->name('invoice.download');
    Route::get('user/order/{id}', [UserController::class, 'Ordershow'])->name('order.success');
    Route::get('direct-referrals', [UserController::class, 'directReferrals'])->name('direct.referrals');
    Route::get('downline', [UserController::class, 'downline'])->name('downline');
 Route::get('transactions', [UserController::class, 'Transactions'])
    ->name('transactions');
    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');
});
Route::post('/webhook/github', [WebhookController::class, 'handleWebhook']);
// Route::any('{any}', function () {
//     return view('fronts.inc.error');
// })->where('any', '.*');
