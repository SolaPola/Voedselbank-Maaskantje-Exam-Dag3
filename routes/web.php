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

// Role-based dashboards
Route::middleware(['auth', 'verified', 'role:1'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
    
    // Food packages route for managers
    Route::get('/food-packages', [FamilyFoodPackageController::class, 'index'])->name('FoodPackages.food-packages');
});

Route::middleware(['auth', 'verified', 'role:2'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

// Volunteer routes
Route::middleware(['auth', 'verified', 'role:3'])->group(function () {
    Route::get('/volunteer/dashboard', [VolunteerDashboardController::class, 'index'])->name('volunteer.dashboard');
    Route::get('/volunteer/food-packages', [FamilyFoodPackageController::class, 'volunteerIndex'])->name('volunteer.food-packages');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // View food packages for a family
    Route::get('/food-packages/family/{id}', [FamilyFoodPackageController::class, 'showFamilyPackages'])
        ->middleware(['role:1,3']) // Allow both managers and volunteers
        ->name('food-packages.family');
    
    // Edit food package status form
    Route::get('/food-packages/{id}/edit', [FamilyFoodPackageController::class, 'editStatus'])
        ->middleware(['role:1,3']) // Allow both managers and volunteers
        ->name('food-packages.edit');
    
    // Update food package status
    Route::post('/food-packages/{id}/update', [FamilyFoodPackageController::class, 'updateStatus'])
        ->middleware(['role:1,3']) // Allow both managers and volunteers
        ->name('food-packages.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/auth.php';
