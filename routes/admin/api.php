<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\UserController;

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

Route::group(['middleware' => 'jwt_auth'], function () {
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('profile', [UserController::class, 'list']);
        Route::get('profile/{id}', [UserController::class, 'show']);
        Route::put('profile/{id}', [UserController::class, 'update']);
        Route::post('profile', [UserController::class, 'store']);
        Route::delete('profile/{id}', [UserController::class, 'delete']);
        Route::post('change-password/{id}', [UserController::class, 'changePassword']);
    });
});
