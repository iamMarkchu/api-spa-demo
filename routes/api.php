<?php

use Illuminate\Http\Request;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Access-Control-Allow-Headers, X-Requested-With');
header('Access-Control-Allow-Methods: *');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('articles', 'ArticleController');
Route::resource('categories', 'CategoryController');
Route::resource('tags', 'TagController');
