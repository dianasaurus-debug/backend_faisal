<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController as APIAuthController;
use App\Http\Controllers\API\NotificationController as APINotificationController;
use App\Http\Controllers\API\ContactController as APIContactController;
use App\Http\Controllers\API\HistoryController as APIHistoryController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/register', [APIAuthController::class, 'register']);
Route::post('/login', [APIAuthController::class, 'login']);
Route::post('/send/test', [APINotificationController::class, 'testting']);


//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/send/whatsapp', [APINotificationController::class, 'send_whatsapp']);
    Route::get('/profile', [APIAuthController::class, 'profile']);
    Route::put('/update', [APIAuthController::class, 'update']);
    Route::post('/logout', [APIAuthController::class, 'logout']);
    Route::get('contact/all', [APIContactController::class, 'index']);
    Route::post('contact/create', [APIContactController::class, 'store']);
    Route::delete('contact/delete/{id}', [APIContactController::class, 'destroy']);
    Route::post('contact/update/{id}', [APIContactController::class, 'update']);
    Route::get('history/all', [APIHistoryController::class, 'index']);
    Route::post('history/create', [APIHistoryController::class, 'store']);
});
