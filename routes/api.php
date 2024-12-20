<?php

use App\Domain\Inventory\Controllers\InventoryController;
use App\Domain\Order\Controllers\OrderController;
use App\Domain\Product\Controllers\ProductController;
use App\Domain\Warehouse\Controllers\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/

Route::get('/product', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Warehouse Routes
|--------------------------------------------------------------------------
*/

Route::get('/warehouse', [WarehouseController::class, 'index']);
Route::post('/warehouse', [WarehouseController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Inventory Routes
|--------------------------------------------------------------------------
*/

Route::get('/inventory', [InventoryController::class, 'index']);
Route::post('/inventory', [InventoryController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
*/

Route::get('/order', [OrderController::class, 'index']);
Route::post('/order', [OrderController::class, 'store']);
