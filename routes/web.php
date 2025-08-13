<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Custom logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('message', 'You have been logged out successfully.');
})->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management routes
    Route::get('/admin/users', [App\Http\Controllers\UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [App\Http\Controllers\UserManagementController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [App\Http\Controllers\UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    
    // Product Management routes
    Route::get('/admin/products', [App\Http\Controllers\ProductManagementController::class, 'index'])->name('admin.products.index');
    
    // Category Management routes
    Route::post('/admin/categories', [App\Http\Controllers\ProductManagementController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/admin/categories/{category}', [App\Http\Controllers\ProductManagementController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [App\Http\Controllers\ProductManagementController::class, 'destroyCategory'])->name('admin.categories.destroy');
    
    // Product routes
    Route::post('/admin/products/store', [App\Http\Controllers\ProductManagementController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/admin/products/{product}', [App\Http\Controllers\ProductManagementController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [App\Http\Controllers\ProductManagementController::class, 'destroyProduct'])->name('admin.products.destroy');
});

// Employee routes
Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/employee/dashboard', [App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

// POS Terminal routes (accessible by both admin and employee)
Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/pos/terminal', [App\Http\Controllers\POSTerminalController::class, 'index'])->name('pos.terminal');
    Route::post('/pos/add-to-cart', [App\Http\Controllers\POSTerminalController::class, 'addToCart'])->name('pos.add-to-cart');
    Route::post('/pos/remove-from-cart', [App\Http\Controllers\POSTerminalController::class, 'removeFromCart'])->name('pos.remove-from-cart');
    Route::post('/pos/process-transaction', [App\Http\Controllers\POSTerminalController::class, 'processTransaction'])->name('pos.process-transaction');
});
