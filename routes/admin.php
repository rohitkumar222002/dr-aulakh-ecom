<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Basic\BasicController;
use App\Http\Controllers\Basic\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\Management\UsersManagementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate');
        return 'Migrations ran successfully!';
    } catch (\Exception $e) {
        return 'Error running migrations: ' . $e->getMessage();
    }
});

// Route::get('/rollback-migrations', function () {
//     try {
//         Artisan::call('migrate:rollback');
//         return 'Migrations Rollback successfully!';
//     } catch (\Exception $e) {
//         return 'Error running migrations: ' . $e->getMessage();
//     }
// });

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AdminController::class, 'toAdminLogin'])->name('login');
});

Route::group(['middleware' => ['auth:admin', 'user.active']], function () {
    Route::get('/dashboard', [AdminController::class, 'toAdminDashboard'])->name('dashboard');

   Route::resource('products', ProductController::class);
   Route::resource('categories', CategoryController::class);
   Route::resource('subcategories', SubcategoryController::class);
   Route::resource('articles', ArticleController::class);
   Route::resource('coupons', CouponController::class);
    Route::resource('levels', LevelController::class);

    // Users
    Route::get('/users', [UsersManagementController::class, 'tousers'])->name('users');
    Route::put('/users/{id}', [UsersManagementController::class, 'UserUpdate'])->name('users.update');
    Route::delete('user-delete/{id}', [UsersManagementController::class, 'UserDelete'])->name('user-delete');
    Route::get('/user/view/{slug}', [UsersManagementController::class, 'touserview'])->name('user.view');
    //universalSearch
    Route::get('/universal-search', [AdminController::class, 'universalSearch'])->name('universalSearch');
    Route::get('/admin/users/{id}', [AdminController::class, 'show'])->name('admin.users.show');

    Route::get('transactions', [AdminController::class, 'transactions'])
    ->name('transactions');


Route::get('users/{user}/transactions', [AdminController::class, 'userTransactions'])
    ->name('users.transactions');

    // Notifications
    Route::get('/notifications', [BasicController::class, 'Notifications'])->name('notification');

    // GetSettings
    Route::get('/settings', [AdminController::class, 'toSettings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'toSettingUpload']);

    // Slider
    Route::get('/sliders', [SliderController::class, 'Sliders'])->name('slider');
    Route::post('/sliders', [SliderController::class, 'SlidersStore']);
    Route::post('/slider/update', [SliderController::class, 'SliderUpdate'])->name('slider.update');
    Route::delete('slider/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete');

    Route::get('/orders', [AdminController::class, 'Orders'])->name('orders');
  Route::get('/orders/{id}/view', [AdminController::class, 'viewOrder'])->name('orders.view');
    Route::patch('/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])
    ->name('orders.update-status');


    // Custom Pages
    Route::get('/custom-pages', [AdminController::class, 'toCustom'])->name('custom-page-all');
    Route::get('/custom-pages/create', [AdminController::class, 'toCustomPage'])->name('custom-page');
    Route::post('/custom-pages/create', [AdminController::class, 'toCustomPageSave']);
    Route::get('/custom-pages/update/{id}', [AdminController::class, 'toCustomPageEdit'])->name('custom-page-edit');
    Route::put('/custom-pages/update/{id}', [AdminController::class, 'toCustomPageUpdate'])->name('custom-page-update');
    Route::delete('custom-pages/delete/{id}', [AdminController::class, 'toCustomPageDelete'])->name('custom-page.delete');


    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');

    // Upload
    Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
    Route::resource('/uploaded-files', AizUploadController::class);
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class, 'destroy'])->name('uploaded-files.destroy1');


    
Route::get('/download/users', [AdminController::class, 'downloadUsers'])->name('download.users');
        // agents
    });
