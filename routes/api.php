<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', "DefaultController@defaultMessage");

Route::post('login', "AuthController@login")->name('login');

Route::group(['middleware' => 'auth:api'], function() {

    Route::group(['prefix' => 'user'], function() {
        Route::get('/', 'UserController@index')->middleware('permission:View User');
        Route::get('{user}', 'UserController@show')->middleware('permission:View User');
        Route::post('/', 'UserController@store')->middleware('permission:Create User');
        Route::delete('{user}', 'UserController@destroy')->middleware('permission:Delete User');
        Route::match(['put', 'patch'], '{user}', 'UserController@update')->middleware('permission:Modify User');
    });

    Route::group(['prefix' => 'building'], function() {
        Route::get('/', 'BuildingController@index')->middleware('permission:View Building');
        Route::post('/', 'BuildingController@store')->middleware('permission:Create Building');
        
        Route::group(['prefix' => '{header}'], function() {
            Route::get('/', 'BuildingController@show')->middleware('permission:View Building');
            Route::match(['put', 'patch'], '/', 'BuildingController@update')->middleware('permission:Modify Building');
            Route::delete('/', 'BuildingController@destroy')->middleware('permission:Delete Building');
            
            Route::group(['prefix' => 'detail'], function () {
                Route::post('/', 'DetailController@store')->middleware('permission:Create Building');
                Route::get('{id}', 'DetailController@show')->middleware('permission:View Building');
                Route::match(['put', 'patch'], '{id}', 'DetailController@update')->middleware('permission:Modify Building');
                Route::delete('{id}', 'DetailController@destroy')->middleware('permission:Delete Building');
            });
        }); 
    });

    Route::post('logout', "AuthController@logout")->name('logout');
});

