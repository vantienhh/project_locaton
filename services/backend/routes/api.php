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

Route::post('login', 'AccountController@login')->name('login');
Route::post('register', 'AccountController@register');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/profile', 'UserController@profile');
    Route::get('/logout', 'AccountController@logout')->name('logout');

    // province
    Route::get('/get_provinces', 'ProvinceController@index');
    Route::get('/province_population', 'ProvinceController@getProvincePopulation');

    //district
    Route::get('/get_districts', 'DistrictController@index');
    Route::get('/district_population', 'DistrictController@getDistrictPopulation');
});

Route::group(['middleware' => ['auth:api', 'rateLimit200Request']], function () {
    // province rate limit 200
    Route::get('/limit_200/get_provinces', 'ProvinceController@index');
    Route::get('/limit_200/province_population', 'ProvinceController@getProvincePopulation');

    //district rate limit 200
    Route::get('/limit_200/get_districts', 'DistrictController@index');
    Route::get('/limit_200/district_population', 'DistrictController@getDistrictPopulation');
});

Route::group(['middleware' => ['auth:api', 'rateLimit20Request']], function () {
    // province rate limit 20
    Route::get('/limit_20/get_provinces', 'ProvinceController@index');
    Route::get('/limit_20/province_population', 'ProvinceController@getProvincePopulation');

    //district rate limit 20
    Route::get('/limit_20/get_districts', 'DistrictController@index');
    Route::get('/limit_20/district_population', 'DistrictController@getDistrictPopulation');
});

