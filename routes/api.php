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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('users/{id}/activity', 'ActivityController@usersActivities');
Route::middleware('auth:api')->get('users/{id}/post', 'PostController@usersPosts');
Route::middleware('auth:api')->get('activity/feed/{order}', 'ActivityController@feed');
Route::middleware('auth:api')->get('post/feed/{order}', 'PostController@feed');
Route::middleware('auth:api')->get('users/following', 'UsersController@following');
Route::middleware('auth:api')->get('users/search/{name}', 'UsersController@search');
Route::middleware('auth:api')->get('admin/pdf', 'AdminController@pdf');
Route::middleware('auth:api')->post('follow/unfollow', 'FollowController@unfollow');
Route::middleware('auth:api')->resource('activity', 'ActivityController');
Route::middleware('auth:api')->resource('post', 'PostController');
Route::middleware('auth:api')->resource('follow', 'FollowController');
Route::middleware('auth:api')->resource('users', 'UsersController');
Route::middleware('auth:api')->resource('admin', 'AdminController');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'Auth\RegisterController@create');

});