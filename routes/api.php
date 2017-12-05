<?php

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
Route::post('/deploy', 'WebHook\DeploymentController@deploy');// webhook

Route::group(['prefix' => '/', 'namespace' => 'Api', 'middleware' => ['api']], function () {
    Route::get('/articles', 'ArticleController@index');// 文章
    Route::post('/articles/sidebar', 'ArticleController@getSidebar');// 获取文章侧边栏数据
    Route::get('/articles/{id}', 'ArticleController@show')->where('id', '[0-9]+');// 获取文章详情
    Route::post('/register', 'RegisterController@register')->middleware('verifyEmailCode');// 注册
    Route::post('/verification_code/send', 'VerificationController@send')->middleware('checkEmail');// 邮件发送
    Route::get('/captcha/get', 'CaptchaController@getCaptcha');// 获取验证码
    Route::post('/login', 'LoginController@login')->middleware('verifyCaptcha');// 登录
//    Route::post('/token/refresh', 'LoginController@refresh');// 获取新的access_token
});

Route::group(['prefix' => '/', 'namespace' => 'Api', 'middleware' => ['auth:api']], function () {
    Route::post('/logout ', 'LoginController@logout');// 退出登录
    Route::get('/user', 'UserController@getUserInfo');// 获取用户信息
    Route::post('/user/update', 'UserController@update');// 修改用户信息
    Route::post('/user/update_password', 'UserController@updatePassword')->middleware('checkPassword');// 修改用户密码
    Route::post('/image/upload', 'ImageController@upload');// 上传图片
    Route::resource('/categories', 'CategoryController');// 文章类别列表
    Route::post('/articles', 'ArticleController@store');// 发布文章
    Route::post('/articles/delete/{id}', 'ArticleController@destroy')->where('id', '[0-9]+');// 删除文章
    Route::get('/articles/edit/{id}', 'ArticleController@edit')->where('id', '[0-9]+');// 修改文章
    Route::post('/articles/{id}', 'ArticleController@update')->where('id', '[0-9]+');
    Route::post('/tags/list', 'TagController@list');// 获取标签
});
