<?php

use App\Http\Controllers\BrokerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Broker management routes
Route::middleware('auth:sanctum')->group(function () {
    // Standard CRUD operations
    Route::apiResource('brokers', BrokerController::class);
    
    // Additional broker routes
    Route::post('brokers/{broker}/add-sales', [BrokerController::class, 'addSales']);
    Route::get('users/{user}/brokers', [BrokerController::class, 'byUser']);
    Route::get('brokers-statistics', [BrokerController::class, 'statistics']);
});
