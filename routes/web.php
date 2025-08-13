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
    
    // Product Management routes (design only - server-side to be implemented)
    Route::get('/admin/products', [App\Http\Controllers\ProductManagementController::class, 'index'])->name('admin.products.index');
    
    // Sales & Transactions routes
    Route::get('/admin/sales', [App\Http\Controllers\SalesController::class, 'index'])->name('admin.sales.index');
    
    // Business Intelligence routes
    Route::get('/admin/business-intelligence', [App\Http\Controllers\BusinessIntelligenceController::class, 'index'])->name('admin.business-intelligence.index');
    
    // Accounting & Finance routes
    Route::get('/admin/accounting', [App\Http\Controllers\AccountingController::class, 'index'])->name('admin.accounting.index');
    
    // Advanced Inventory routes
    Route::get('/admin/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('admin.inventory.index');
    
    // Purchase Orders routes
    Route::get('/admin/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'index'])->name('admin.purchase-orders.index');
    
    // Reports routes
    Route::get('/admin/reports', [App\Http\Controllers\ReportsController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/daily-sales', [App\Http\Controllers\ReportsController::class, 'dailySales'])->name('admin.reports.daily-sales');
    Route::get('/admin/reports/order-history', [App\Http\Controllers\ReportsController::class, 'orderHistory'])->name('admin.reports.order-history');
    Route::get('/admin/reports/supplies-list', [App\Http\Controllers\ReportsController::class, 'suppliesList'])->name('admin.reports.supplies-list');
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
