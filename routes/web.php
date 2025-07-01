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

// Role-based dashboards
Route::middleware(['auth', 'verified', 'role:1'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
    Route::get('/product-stock', [ProductStockController::class, 'index'])->name('product-stock.index');
    Route::get('/product-stock/data', [ProductStockController::class, 'getData'])->name('product-stock.data');
});

Route::middleware(['auth', 'verified', 'role:2'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    Route::get('/product-stock', [ProductStockController::class, 'index'])->name('product-stock.index');
    Route::get('/product-stock/data', [ProductStockController::class, 'getData'])->name('product-stock.data');
});

Route::middleware(['auth', 'verified', 'role:3'])->group(function () {
    Route::get('/volunteer/dashboard', [VolunteerDashboardController::class, 'index'])->name('volunteer.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
