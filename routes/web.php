<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome')->name('home');
Route::view('/tentang-kami', 'about')->name('about');
Route::view('/produk', 'product')->name('product');
Route::view('/studi-kasus', 'case-study')->name('casestudy');

Route::view('/login', 'login')->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard')
            ]);
        }
        return redirect()->intended('/dashboard');
    }

    if ($request->wantsJson()) {
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah. Silakan coba lagi.'
        ], 401);
    }

    return back()->withErrors([
        'email' => 'Email atau password salah. Silakan coba lagi.',
    ])->onlyInput('email');
});

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;

Route::post('/midtrans/notification', [OrderController::class, 'handleNotification'])->name('midtrans.notification');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [InventoryController::class, 'index'])->name('dashboard');
    Route::get('/products/check-sku', [InventoryController::class, 'checkSku'])->name('products.check-sku');
    Route::post('/products', [InventoryController::class, 'store'])->name('products.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{orderId}/mark-as-paid', [OrderController::class, 'markAsPaid'])->name('orders.mark-as-paid');
    Route::view('/integrations', 'integrations')->name('integrations');
    
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'redirect' => route('login')]);
        }
        return redirect('/login');
    })->name('logout');
});
