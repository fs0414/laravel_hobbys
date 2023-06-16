<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CommentsController;

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

Route::group([
    'name' => 'auth.',
], function() {
    Route::get('users', [AuthController::class, 'allUser']);
    Route::post('me', [AuthController::class, 'me']);
    Route::group([ 'prefix' => 'auth', ], function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

Route::group([
    'name' => 'article.',
], function() {
    Route::resource('article', ArticlesController::class)->except([
        'create', 'edit'
    ]);
    Route::get('softDeleteArticles', [ArticlesController::class, 'softDeleteIndex']);
});

Route::resource('comment', CommentsController::class)->except([
    'create', 'edit',
]);

// Route::get('comment', [CommentsController::class, 'index']);
// Route::post('comment', [CommentsController::class, 'store']);
