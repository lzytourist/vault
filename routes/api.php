<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\NoteController;
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

Route::resource('/credit', CreditController::class);
Route::resource('/expenditure', ExpenditureController::class);
Route::resource('/note', NoteController::class);

Route::post('/login', '\App\Http\Controllers\AuthController@login');
Route::post('/register', '\App\Http\Controllers\AuthController@register');
Route::post('/logout', '\App\Http\Controllers\AuthController@logout');
