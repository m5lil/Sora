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


// Auth::guard('api')->user();
// Route::group(['middleware' => 'auth:api'], function() {
// Route::resource('/users', 'ApiUserController');
// });
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('users', 'ApiUserController');
Route::resource('roles', 'RolesController');
Route::resource('permissions', 'PermissionController');
Route::resource('menus', 'MenuController');
Route::resource('pages', 'PageController');
