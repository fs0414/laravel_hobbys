<?php

use App\Http\Controllers\LineItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'as' => 'product.',
], function() {
    Route::get('products', [ProductController::class, 'index'])->name('index');
    Route::get('product/{id}', [ProductController::class, 'show'])->name('show');
});

Route::group([
    'as' => 'cart.',
], function() {
    Route::get('cart' , [CartController::class, 'index'])->name('index');
    Route::get('cart/checkout', [CartController::class, 'checkout'])->name('checkout');
});

Route::group([
    'as' => 'line_item.',
], function() {
    Route::post('line_item/create', [LineItemController::class, 'create'])->name('create');
    Route::delete('line_item/delete', [LineItemController::class, 'delete'])->name('delete');
    Route::get('line_item/delete', [LineItemController::class, 'delete'])->name('delete');
});