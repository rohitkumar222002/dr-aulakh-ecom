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
use App\Livewire\ContactPage;
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

Route::get('/faq', Faq::class)->name('site.faq');
Route::get('/cache_clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
});
Route::get('/guided-purchase', GuidedPurchase::class)
    ->name('site.guided.purchase');
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
Route::get('/science-backed', ScienceBacked::class)->name('science.backed');
Route::get('/science-of-health', ScienceOfHealth::class)->name('science.health');
Route::get('/doctors-desk', DoctorsDesk::class)->name('doctors.desk');
 Route::get('/orders', OrdersPage::class)->name('orders.index');
Route::post('/payment/create-order', [PaymentController::class, 'createOrder'])->name('payment.create-order');
Route::post('/payment/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook'])->name('payment.webhook');

Route::get('/page/{slug}', CustomPagesComponent::class)->name('custom.pages');
Route::get('/thank-you', Thankyou::class)->name('thankyou');
Route::get('/404', Error::class)->name('error');

// Ajax
Route::get('/get-cities/{stateId}', [LocationController::class, 'getCities']);
Route::get('/get-blocks/{cityId}', [LocationController::class, 'getBlocks']);
Route::get('/products/filter', [LocationController::class, 'filter'])->name('products.filter');
Route::get('/products/cities', [LocationController::class, 'getCitiesByState'])->name('products.getCitiesByState');
Route::get('/products/blocks', [LocationController::class, 'getBlocksByCity'])->name('products.getBlocksByCity');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [BasicController::class, 'toLogout'])->name('logout');
});

Route::get('/logout', function () {
    Auth::logout(); // Logs out the current user
    request()->session()->invalidate(); // Invalidate the session
    request()->session()->regenerateToken(); // Regenerate the CSRF token for security
    return redirect()->route('login'); // Redirect to the login page (or any other route)
})->name('logout');


Route::group(['middleware' => ['auth:web', 'user.active'],  'as' => 'user.'], function () {
    Route::get('/dashboard', [UserController::class, 'toUserDashboard'])->name('dashboard');
    Route::get('profile', [UserController::class, 'UserProfile'])->name('profile');
    Route::put('profile', [UserController::class, 'UserProfileUpdate'])->name('profileupdate');
  
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
