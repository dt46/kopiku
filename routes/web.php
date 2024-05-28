<?php

use App\Http\Controllers\auth\SignInController;
use App\Http\Controllers\auth\SignUpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResellerController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'de', 'es', 'fr', 'pt', 'cn', 'ae'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');

// ======================================================================
Route::prefix('/')->group(function () {
    Route::redirect('/', '/signin');
    Route::get('/signin', [SignInController::class, 'index'])->name('signin');
    Route::post('/signin', [SignInController::class, 'login']);
    Route::post('/signout', [SignInController::class, 'logout']);
    Route::controller(SignUpController::class)
        ->group(function () {
            Route::get("/signup", 'index')->name("signup");
            Route::post("/signup", 'signUp');
        });
});

Route::prefix('/admin')->group(function () {
    Route::redirect('/admin', '/signin');
    Route::controller(SignInController::class)->group(function () {
        Route::get("/signin", 'indexAdmin')->name('indexAdmin');
        Route::post('/signin', 'login');
        Route::post('/signout', 'logout');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)
        ->middleware('IsAdmin')
        ->group(function () {
            Route::get('/dashboard', 'index')->name('index');
        });

    Route::controller(ResellerController::class)->middleware('IsReseller')->group(function () {
        Route::get('/dashboard-reseller', 'index')->name('index-reseller');
        Route::get('/profile-reseller', 'showProfile');
        Route::put('/update-profile-reseller', 'updateProfile');
    });

    Route::controller(ResellerController::class)->middleware('IsAdmin')->group(function () {
       Route::get('/daftar-reseller', 'show')->name('daftar-reseller');
       Route::get('/pengajuan-reseller', 'showPengajuan')->name('pengajuan-reseller');
       Route::put('/update-status/{reseller}', 'updateStatus');
       Route::get('/update-data/{reseller}', 'showResellerId');
       Route::put('/update-data/{reseller}', 'update');
    });

    Route::controller(ProductController::class)->middleware('IsAdmin')->group(function () {
        Route::get('/daftar-produk', 'index')->name('daftar-produk');
        Route::get('/tambah-produk', 'showTambahProduk')->name('tambah-produk');
        Route::post('/tambah-produk', 'store')->name('tambah-produk');
        Route::get('/update-data-produk/{product}', 'showProdukId');
        Route::put('/update-data-produk/{product}', 'update');
        Route::delete('/delete-produk/{id}', 'destroy');
    });

    Route::controller(ProductController::class)->middleware('IsReseller')->group(function () {
        Route::get('/produk', 'show')->name('produk');
    });

    Route::controller(OrderController::class)->middleware('IsReseller')->group(function () {
        Route::get('/order/{product}', 'index')->name('order');
        Route::post('/store-order', 'store')->name('store-order');
    });

    Route::controller(OrderController::class)->middleware('IsAdmin')->group(function () {
        Route::get('/daftar-order', 'showIndex')->name('daftar-order');
        Route::get('/update-status/{order}', 'showOrderId');
        Route::put('/update-resi/{order}', 'update');
    });
    
    Route::controller(OrderController::class)->middleware('IsReseller')->group(function () {
        Route::get('/daftar-pesanan', 'indexReseller')->name('daftar-order-reseller');
        Route::get('/update-status-order/{order}', 'showOrderId');
        Route::put('/update-status-order/{order}', 'updateStatus');
    });
});



//========================================================================================

// Route::prefix('starter-kit')->group(function () {
// });

Route::prefix('others')->group(function () {
    Route::view('400', 'errors.400')->name('error-400');
    Route::view('401', 'errors.401')->name('error-401');
    Route::view('403', 'errors.403')->name('error-403');
    Route::view('404', 'errors.404')->name('error-404');
    Route::view('500', 'errors.500')->name('error-500');
    Route::view('503', 'errors.503')->name('error-503');
});


Route::get('layout-{light}', function ($light) {
    session()->put('layout', $light);
    session()->get('layout');
    if ($light == 'vertical-layout') {
        return redirect()->route('pages-vertical-layout');
    }
    return redirect()->route('index');
    return 1;
});
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

