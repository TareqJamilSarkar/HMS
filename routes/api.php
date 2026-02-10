<?php

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

// Room Status API Routes
Route::get('/room-statuses', [\App\Http\Controllers\RoomStatusController::class, 'getStatuses']);
Route::post('/room-statuses', [\App\Http\Controllers\RoomStatusController::class, 'updateStatus']);
