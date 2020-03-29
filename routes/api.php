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

Route::get('/user', 'RoomController@getUser');
Route::post('/rooms', 'RoomController@createRoom');
Route::get('/rooms/{room}', 'RoomController@getRoom');
Route::post('/rooms/{room}/reset', 'RoomController@reset');
Route::post('/rooms/{room}/join/{user}', 'RoomController@joinRoom');

Route::group(['prefix' => '/rooms/{room}/{user}/'], function () {
    Route::post('sleep', 'RoomController@fallAsleep');
    Route::post('action', 'RoomController@doAction');
});


Route::post('/webhooks/pusher', 'PusherController@webhooks');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
