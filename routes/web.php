<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\FamilyFoodPackageController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
require __DIR__ . '/auth.php';
require __DIR__ . '/auth.php';
