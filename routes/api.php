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

Route::options('/{all}', function(Request $request) {
    $origin = $request->header('ORIGIN', '*');
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Access-Control-Request-Headers, SERVER_NAME, Access-Control-Allow-Headers, cache-control, token, X-Requested-With, Content-Type, Accept, Connection, Authorization,User-Agent, Cookie');
})->where(['all' => '([a-zA-Z0-9-]|/)+']);

Route::group(['prefix' => 'auth','middleware'=>['AllowOrigin']], function () {
    Route::post('login', 'Api\UserController@login');
    Route::post('logout', 'Api\UserController@logout');
    Route::post('refresh', 'Api\UserController@refresh');

    Route::group(['middleware' => ['jwt.role:AlMember', 'jwt.auth']], function () {
        Route::post('userInfo', 'Api\UserController@userInfo')->name('api.userInfo');
        Route::post('airLineSearch', 'Api\UserController@airLineSearch')->name('api.airLineSearch');
    });
});
