<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;

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

Route::group(["prefix" => "v1/"], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::group(["prefix" => "user", "as" => "user."], function () {
            Route::post("register", "register")->name("register");
            Route::post("login", "login")->name("login");
            Route::group(["middleware" => "auth:sanctum"], function () {
                Route::get("logout", "logout")->name("logout");
            });
        });
    });
});
