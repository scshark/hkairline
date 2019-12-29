<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('login', 'Api\UserController@login');

// Route::group(['middleware' => 'auth.jwt'], function () {

//     Route::post('user', 'Api\UserController@getAuthUser');
// });
Route::group(['prefix' => 'auth','middleware'=>['AccessControlAllowOrigin']], function () {
    Route::post('login', 'Api\UserController@login');
    Route::post('logout', 'Api\UserController@logout');
    Route::post('refresh', 'Api\UserController@refresh');

    Route::group(['middleware' => ['jwt.role:AlMember', 'jwt.auth']], function () {
        Route::post('userInfo', 'Api\UserController@userInfo')->name('api.userInfo');
        Route::post('airLineSearch', 'Api\UserController@airLineSearch')->name('api.airLineSearch');
    });
});
