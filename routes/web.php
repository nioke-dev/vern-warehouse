<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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

Route::view('/register', 'register')->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Password::min(6)],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    // Beri kategori awal untuk user baru (milik mereka sendiri).
    // user_id otomatis terisi oleh trait BelongsToUser karena sudah login.
    foreach (['Frozen Food', 'Snacks', 'Bakery'] as $categoryName) {
        \App\Models\Category::create(['name' => $categoryName]);
    }

    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'redirect' => route('dashboard'),
        ]);
    }

    return redirect()->intended('/dashboard');
});

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageOrderController;
use App\Http\Controllers\DashboardHomeController;

Route::post('/midtrans/notification', [OrderController::class, 'handleNotification'])->name('midtrans.notification');
Route::post('/package-orders', [PackageOrderController::class, 'store'])->name('package-orders.store');
Route::post('/midtrans/package-notification', [PackageOrderController::class, 'handleNotification'])->name('midtrans.package-notification');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/home', [DashboardHomeController::class, 'index'])->name('dashboard.home');
    Route::get('/dashboard', [InventoryController::class, 'index'])->name('dashboard');
    Route::get('/products/check-sku', [InventoryController::class, 'checkSku'])->name('products.check-sku');
    Route::post('/products', [InventoryController::class, 'store'])->name('products.store');
    Route::post('/categories', [InventoryController::class, 'storeCategory'])->name('categories.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{orderId}/mark-as-paid', [OrderController::class, 'markAsPaid'])->name('orders.mark-as-paid');
    Route::view('/integrations', 'integrations')->name('integrations');

    Route::post('/profile', function (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $targetDir = public_path('uploads/profiles');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
            copy($file->getRealPath(), $targetPath);
            $user->profile_photo_path = url('uploads/profiles/' . $fileName);
        }

        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'name' => $user->name,
                'initials' => $user->initials(),
                'photo' => $user->profile_photo_path,
            ]);
        }

        return back();
    })->name('profile.update');
    
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
