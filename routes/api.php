<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Access-Control-Allow-Headers, X-Requested-With');
header('Access-Control-Allow-Methods: *');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Article
Route::get('/public/articles', 'ArticleController@index');
Route::get('/public/articles/{id}', 'ArticleController@show');
Route::resource('articles', 'ArticleController')->middleware('auth:api');
Route::put('articles/{id}/publish', 'ArticleController@publish')->middleware('auth:api');
Route::put('articles/{id}/revoke', 'ArticleController@revoke')->middleware('auth:api');

// Category
Route::resource('categories', 'CategoryController')->middleware('auth:api');
Route::get('categories-all', 'CategoryController@all');

Route::resource('tags', 'TagController')->middleware('auth:api');
Route::get('tags-all', 'TagController@all');

// Register & Login
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');

// Upload
\LaravelUploader::routes();

// System Config

Route::resource('configs', 'SystemConfigController')->middleware('auth:api');
Route::get('/configs-all', 'SystemConfigController@all');
