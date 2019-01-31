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

Route::get('/', 'HomeController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/request', 'ProductRequestController@store')->name('request.store');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/requests', 'ProductRequestController@index')->name('requests');
    Route::get('/sliders', 'SliderController@index')->name('sliders');
    Route::post('/sliders', 'SliderController@store')->name('sliders.store');
    Route::post('/sliders/delete/{id}', 'SliderController@destroy')->name('sliders.destroy');

    Route::get('/information', 'InformationController@index')->name('information');
    Route::post('/information', 'InformationController@store')->name('information.store');

    Route::get('/additional', 'AdditionalController@index');
    Route::post('/additional', 'AdditionalController@store')->name('additional.store');
    Route::delete('/additional/{id}', 'AdditionalController@destroy')->name('additional.destroy');
});
