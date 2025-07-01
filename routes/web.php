<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\ProductStockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    return redirect($user->getRedirectPath());
})->middleware(['auth', 'verified'])->name('dashboard');

// Debug route to check user roles
Route::get('/debug-roles', function () {
    $user = auth()->user();
    if (!$user) {
        return 'Not authenticated';
    }

    $user->load('roles');
    return response()->json([
        'user_id' => $user->id,
        'user_email' => $user->email,
        'roles' => $user->roles->toArray(),
        'role_ids' => $user->roles->pluck('id')->toArray()
    ]);
})->middleware('auth');

// Manager routes
Route::middleware(['auth', 'verified', 'role:1'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
});

// Employee routes
Route::middleware(['auth', 'verified', 'role:2'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

// Volunteer routes
Route::middleware(['auth', 'verified', 'role:3'])->group(function () {
    Route::get('/volunteer/dashboard', [VolunteerDashboardController::class, 'index'])->name('volunteer.dashboard');
});

// Shared routes for managers and employees
Route::middleware(['auth', 'verified', 'role:1,2'])->group(function () {
    Route::get('/product-stock', [ProductStockController::class, 'index'])->name('product-stock.index');
    Route::get('/product-stock/data', [ProductStockController::class, 'getData'])->name('product-stock.data');
    Route::get('/product-stock/details/{productId}', [ProductStockController::class, 'getProductDetails'])->name('product-stock.details');
    Route::get('/product-stock/show/{productId}', [ProductStockController::class, 'show'])->name('product-stock.show');
    Route::get('/product-stock/edit/{productId}', [ProductStockController::class, 'edit'])->name('product-stock.edit');
    Route::put('/product-stock/update/{productId}', [ProductStockController::class, 'update'])->name('product-stock.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
