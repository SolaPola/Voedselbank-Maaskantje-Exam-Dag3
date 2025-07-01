<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\FamilyFoodPackageController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    return redirect($user->getRedirectPath());
})->middleware(['auth', 'verified'])->name('dashboard');

// Restructure the routes to avoid authorization issues
Route::middleware(['auth', 'verified'])->group(function () {
    // Routes available to all authenticated users
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
    Route::get('/manager/dashboard/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/manager/dashboard/suppliers/{supplier}/products', [SupplierController::class, 'products'])->name('manager.suppliers.products');
    Route::match(['get', 'post'], '/manager/dashboard/products/{product}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
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
}); // Close the middleware group started on line 21

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Customer management routes
    Route::resource('customers', CustomerController::class)->except(['create', 'store', 'destroy']);

    // Manager routes (role:1)
    Route::middleware(['role:1'])->group(function () {
        Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
        Route::get('/food-packages', [FamilyFoodPackageController::class, 'index'])->name('FoodPackages.food-packages');
        Route::get('/food-packages/family/{id}', [FamilyFoodPackageController::class, 'showFamilyPackages'])->name('food-packages.family');
        Route::get('/food-packages/{id}/edit', [FamilyFoodPackageController::class, 'editStatus'])->name('food-packages.edit');
        Route::post('/food-packages/{id}/update', [FamilyFoodPackageController::class, 'updateStatus'])->name('food-packages.update');
    });
    
    // Employee routes (role:2)
    Route::middleware(['role:2'])->group(function () {
        Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    });
    
    // Volunteer routes (role:3)
    Route::middleware(['role:3'])->group(function () {
        Route::get('/volunteer/dashboard', [VolunteerDashboardController::class, 'index'])->name('volunteer.dashboard');
        Route::get('/volunteer/food-packages', [FamilyFoodPackageController::class, 'volunteerIndex'])->name('volunteer.food-packages');
        Route::get('/volunteer/food-packages/family/{id}', [FamilyFoodPackageController::class, 'volunteerShowFamilyPackages'])->name('volunteer.food-packages.family');
        
        // Move these out of any nested middleware to avoid conflicts
        Route::get('/volunteer/food-packages/{id}/edit', [FamilyFoodPackageController::class, 'volunteerEditStatus'])->name('volunteer.food-packages.edit');
        Route::post('/volunteer/food-packages/{id}/update', [FamilyFoodPackageController::class, 'volunteerUpdateStatus'])->name('volunteer.food-packages.update');
    });
});
// Only include this once
require __DIR__ . '/auth.php';
