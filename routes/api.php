<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

// API ROUTE FOR REGISTER A NEW USER
Route::post('register', 'AuthController@register');

// API ROUTE FOR REGISTER A NEW USER
Route::post('login', 'AuthController@login');

// TODO: CREATE AUTHENTICATED ENDPOINTS
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
