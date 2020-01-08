<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 登录
Route::any('/admin/login', 'admin\LoginController@login')->name('admin.login.login');
// 退出登录
Route::get('/admin/loginout', 'admin\LoginController@loginout')->name('admin.login.loginout');

// 后台
Route::group(['middleware'=>'check.login'], function () {

    Route::get('/','admin\IndexController@index');
    Route::any('/admin/index', 'admin\IndexController@index')->name('admin.index.index');
    Route::any('/admin/addMember', 'admin\IndexController@addMember')->name('admin.index.addMember');
    Route::any('/admin/changeMemberStatus', 'admin\IndexController@changeMemberStatus')->name('admin.index.changeMemberStatus');
    Route::any('/admin/resetMemberPassword', 'admin\IndexController@resetMemberPassword')->name('admin.index.resetMemberPassword');
    Route::any('/admin/deleteMember', 'admin\IndexController@deleteMember')->name('admin.index.deleteMember');
    Route::any('/admin/airLine', 'admin\IndexController@airLine')->name('admin.index.airLine');


    Route::any('/admin/routeSearch', 'admin\RouteSearchController@index')->name('admin.routeSearch.index');
    Route::any('/admin/routeSearch/importExcel', 'admin\RouteSearchController@importExcel')->name('admin.routeSearch.importExcel');

    Route::any('/admin/routeSearch/deleteSearch', 'admin\RouteSearchController@deleteSearch')->name('admin.routeSearch.deleteSearch');

    Route::any('/admin/routeSearch/searchInfo', 'admin\RouteSearchController@searchInfo')->name('admin.routeSearch.searchInfo');

    Route::any('/admin/routeSearch/editSearch', 'admin\RouteSearchController@editSearch')->name('admin.routeSearch.editSearch');
    Route::any('/admin/routeSearch/addSearch', 'admin\RouteSearchController@addSearch')->name('admin.routeSearch.addSearch');
    Route::any('/admin/routeSearch/deleteAirLine', 'admin\RouteSearchController@deleteAirLine')->name('admin.routeSearch.deleteAirLine');

});
