<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    return redirect($user->getRedirectPath());
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-based dashboards
Route::middleware(['auth', 'verified', 'role:1'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');

    Route::get('/manager/dashboard/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/manager/dashboard/suppliers/{supplier}/products', [SupplierController::class, 'products'])->name('manager.suppliers.products');
    Route::get('/manager/dashboard/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('manager.suppliers.edit');

});

Route::middleware(['auth', 'verified', 'role:2'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
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
