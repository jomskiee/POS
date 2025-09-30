<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Broker\FishTypesController;
use App\Http\Controllers\Broker\FishBoxController;
use App\Http\Controllers\Admin\FishManagementController;
use App\Http\Controllers\Broker\SalesController;
use App\Http\Controllers\Broker\FishboxManagementController;
use App\Http\Controllers\BrokerDashboardController;
use App\Http\Controllers\SalesManagementController;
use App\Http\Controllers\ProfileController;
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

// Profile routes - available to all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::put('/', 'update')->name('update');
    });
});

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


    // Sales Management routes - grouped by controller
    Route::controller(SalesManagementController::class)->prefix('admin/sales')->name('admin.sales.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
});

// Broker routes
Route::middleware(['auth', 'broker'])->group(function () {
    Route::get('/broker/dashboard', [BrokerDashboardController::class, 'index'])->name('broker.dashboard');
    Route::get('/broker/analytics', [SalesManagementController::class, 'analytics'])->name('broker.sales.analytics');
    Route::get('/broker/sales', [SalesManagementController::class, 'sales'])->name('broker.sales.sales');

    // Fishbox Management routes for brokers
    Route::controller(FishboxManagementController::class)->prefix('broker')->name('broker.')->group(function () {
        Route::get('/inventory', 'index')->name('inventory.index');
    });

    // Fish Types Management routes for brokers
    Route::controller(FishTypesController::class)->prefix('broker')->name('broker.')->group(function () {
        Route::post('/fish-types', 'store')->name('fish-types.store');
        Route::put('/fish-types/{id}', 'update')->name('fish-types.update');
        Route::delete('/fish-types/{id}', 'destroy')->name('fish-types.destroy');
    });

    // Fish Box Management routes for brokers
    Route::controller(FishBoxController::class)->prefix('broker')->name('broker.')->group(function () {
        Route::post('/fish-boxes', 'store')->name('fish-boxes.store');
        Route::put('/fish-boxes/{id}', 'update')->name('fish-boxes.update');
        Route::delete('/fish-boxes/{id}', 'destroy')->name('fish-boxes.destroy');
        Route::post('/fish-boxes/return-to-stock', 'returnToStock')->name('fish-boxes.return-to-stock');
        Route::post('/fish-boxes/return-via-qr', 'returnFishBoxViaQr')->name('fish-boxes.return-via-qr');
        Route::patch('/fish-boxes/{id}/mark-missing', 'markAsMissing')->name('fish-boxes.mark-missing');
        Route::patch('/fish-boxes/{id}/return', 'returnFishBox')->name('fish-boxes.return');
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
