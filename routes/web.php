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
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'broker') {
            return redirect()->route('broker.dashboard');
        }
    }
    return redirect()->route('login');
});

Auth::routes();

// Custom logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('message', 'You have been logged out successfully.');
})->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User Management routes
    Route::get('/admin/users/{id}/edit', [App\Http\Controllers\UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [App\Http\Controllers\UserManagementController::class, 'update'])->name('admin.users.update');
    Route::patch('/admin/users/{id}/activate', [App\Http\Controllers\UserManagementController::class, 'activate'])->name('admin.users.activate');
    Route::patch('/admin/users/{id}/deactivate', [App\Http\Controllers\UserManagementController::class, 'deactivate'])->name('admin.users.deactivate');
    Route::delete('/admin/users/{id}', [App\Http\Controllers\UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users', [App\Http\Controllers\UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [App\Http\Controllers\UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [App\Http\Controllers\UserManagementController::class, 'store'])->name('admin.users.store');

    // Inventory & Stock Management routes
    Route::get('/admin/inventory', [App\Http\Controllers\InventoryController::class, 'adminIndex'])->name('admin.inventory.index');

    // Sales & Transactions routes
    Route::get('/admin/sales', [App\Http\Controllers\SalesController::class, 'index'])->name('admin.sales.index');
});

// Broker routes
Route::middleware(['auth', 'broker'])->group(function () {
    Route::get('/broker/dashboard', [App\Http\Controllers\BrokerDashboardController::class, 'index'])->name('broker.dashboard');


    // Broker Sales routes
    Route::get('/broker/sales', [App\Http\Controllers\SalesController::class, 'brokerIndex'])->name('broker.sales.index');
});

// POS Terminal routes (accessible by brokers only)
Route::middleware(['auth', 'broker'])->group(function () {
    Route::get('/pos/terminal', [App\Http\Controllers\POSTerminalController::class, 'index'])->name('pos.terminal');
    Route::post('/pos/add-to-cart', [App\Http\Controllers\POSTerminalController::class, 'addToCart'])->name('pos.add-to-cart');
    Route::post('/pos/remove-from-cart', [App\Http\Controllers\POSTerminalController::class, 'removeFromCart'])->name('pos.remove-from-cart');
    Route::post('/pos/process-transaction', [App\Http\Controllers\POSTerminalController::class, 'processTransaction'])->name('pos.process-transaction');
});
