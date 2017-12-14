<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => '/', 'namespace' => 'Admin'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login'); // 登录页面
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout'); // 退出登录
});
Route::group(['prefix' => '/', 'namespace' => 'Admin', 'middleware' => ['auth' => 'auth:admin']], function () {
    Route::get('/', 'AdminController@index');
    Route::post('/admin/update', 'AdminController@update');
    Route::get('/users', 'UserController@index');
    Route::post('/users/toggle_ban/{id}', 'UserController@toggleBan')->where(['id' => '[0-9]+']);
    Route::get('/articles', 'ArticleController@index');
    Route::post('/articles/delete/{id}', 'ArticleController@destroy')->where(['id' => '[0-9]+']);
    Route::post('/tags/delete/{id}', 'TagController@destroy')->where(['id' => '[0-9]+']);
    Route::resource('/categories', 'CategoryController');
    Route::resource('/friendly_links', 'FriendlyLinkController');
});