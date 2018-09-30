<?php

use Illuminate\Http\Request;

// Route::post('/register', 'Auth\AuthController@register');

// Route::post('/login', 'Auth\AuthController@login');

Route::group([
    'middleware' => 'api',
    'namespace'  => 'Auth',
    'prefix' 	 => 'auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post(   'login', 'AuthController@login');
    Route::post(  'logout', 'AuthController@logout');
    Route::post( 'refresh', 'AuthController@refresh');
    Route::post(      'me', 'AuthController@me');
});