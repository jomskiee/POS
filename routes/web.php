<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\FishTypesController;
use App\Http\Controllers\Admin\FishBoxController;
use App\Http\Controllers\Admin\FishManagementController;
use App\Http\Controllers\Broker\SalesController;
use App\Http\Controllers\BrokerDashboardController;
use App\Http\Controllers\SalesManagementController;
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

    // User Management routes - grouped by controller
    Route::controller(UserManagementController::class)->prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::patch('/{id}/activate', 'activate')->name('activate');
        Route::patch('/{id}/deactivate', 'deactivate')->name('deactivate');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Fish Management routes - Main controller that delegates to specific controllers
    Route::controller(FishManagementController::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/inventory', 'index')->name('inventory.index');
    });

    // Fish Types Management routes - grouped by controller
    Route::controller(FishTypesController::class)->prefix('admin')->name('admin.')->group(function () {
        Route::post('/fish-types', 'store')->name('fish-types.store');
        Route::put('/fish-types/{id}', 'update')->name('fish-types.update');
        Route::delete('/fish-types/{id}', 'destroy')->name('fish-types.destroy');
    });

    // Fish Box Management routes - grouped by controller
    Route::controller(FishBoxController::class)->prefix('admin')->name('admin.')->group(function () {
        Route::post('/fish-boxes', 'store')->name('fish-boxes.store');
        Route::put('/fish-boxes/{id}', 'update')->name('fish-boxes.update');
        Route::delete('/fish-boxes/{id}', 'destroy')->name('fish-boxes.destroy');
        Route::get('/fish-boxes/return-to-stock', 'returnToStock')->name('fish-boxes.return-to-stock');
    });

    // Sales & Transactions routes
    Route::get('/admin/sales', [SalesManagementController::class, 'index'])->name('admin.sales.index');
});

// Broker routes
Route::middleware(['auth', 'broker'])->group(function () {
    Route::get('/broker/dashboard', [BrokerDashboardController::class, 'index'])->name('broker.dashboard');
    Route::get('/broker/fish-boxes', [BrokerDashboardController::class, 'fishBoxes'])->name('broker.sales.fish-boxes');
    Route::get('/broker/analytics', [SalesManagementController::class, 'analytics'])->name('broker.sales.analytics');
    Route::get('/broker/sales', [SalesManagementController::class, 'sales'])->name('broker.sales.sales');

    // Fish Box Management routes for brokers
    Route::controller(FishBoxController::class)->prefix('broker')->name('broker.')->group(function () {
        Route::post('/fish-boxes/update-status', 'updateStatus')->name('fish-boxes.update-status');
        Route::patch('/fish-boxes/{id}/mark-missing', 'markAsMissing')->name('fish-boxes.mark-missing');
    });

    // Sales Management routes
    Route::controller(SalesController::class)->prefix('broker')->name('broker.')->group(function () {
        Route::post('/sales', 'store')->name('sales.store');
        Route::put('/sales/{id}', 'update')->name('sales.update');
        Route::delete('/sales/{id}', 'destroy')->name('sales.destroy');
        Route::post('/sales-payments', 'storePayment')->name('sales-payments.store');
        Route::delete('/sales-payments/{id}', 'destroyPayment')->name('sales-payments.destroy');
        Route::get('/sales/fish-boxes/{qrCode}', 'getFishBoxByQRCode')->name('fish-boxes.qr');
    });

});
