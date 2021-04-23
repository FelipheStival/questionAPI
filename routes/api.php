<?php

use App\Http\Controllers\autenticadorController;
use App\Http\Controllers\userController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Authenticacao
Route::prefix('auth')->group(function () {
    Route::post('registro', [autenticadorController::class, 'registro']);
    Route::post('login', [autenticadorController::class, 'login']);

    Route::middleware(['auth:api'])->group(function () {
        Route::post('logout', [autenticadorController::class, 'logout']);
    });
});

//Usuario
Route::group(['prefix' => 'user'], function () {
    Route::middleware(['auth:api'])->group(function () {
        //Route::get('{id}', [userController::class, 'show']);
        Route::get('/info',[userController::class, 'info']);
    });
    Route::get('/image/{id}', [userController::class, 'photo']);
});
