<?php

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Country;
use App\Models\Rate;
use Carbon\Carbon;

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

Route::group(['prefix'=>'api', 'namespace'=>'Api'], function(){
	Route::resource('countries', 'Api\CountryResourceController');
	Route::resource('rates','Api\RateResourceController');
	Route::resource('/currencies/history','Api\CurrencyHistoryController');
	Route::resource('/currencies/latest','Api\CurrencyLatestController');
	Route::resource('/currencies/convert','Api\CurrencyConvertController');
});

/*
**
handle routes with /countries
this will return a list of countries available for currency stuffs
**
*/
Route::get('/countries','Api\CountryResourceController@index');
Route::get('/countries/{id}', 'Api\CountryResourceController@show');
Route::post('/countries/store', 'Api\CountryResourceController@store');
Route::put('/countries/update/{id}', 'Api\CountryResourceController@update');
Route::delete('/countries/delete/{id}', 'Api\CountryResourceController@destroy');

/*
**
handle routes with /rates
this will return a list of countries available for currency stuffs
**
*/
Route::get('/rates','Api\RateResourceController@index');
Route::get('/rates/{id}','Api\RateResourceController@show');
Route::post('/rates/store', 'Api\RateResourceController@store');
Route::put('/rates/update/{id}', 'Api\RateResourceController@update'); //in case of correcting a specific rate
Route::delete('/rates/delete/{id}','Api\RateResourceController@destroy');

/*
**
handle routes with /currencies/history
this will return a list of countries available for currency stuffs
**
*/
Route::get('/currencies/history/batch', 'Api\CurrencyHistoryController@batch');
Route::get('/currencies/history','Api\CurrencyHistoryController@index');
Route::get('/currencies/history/{currency_code}','Api\CurrencyHistoryController@show');


/*
**
handle routes with /currencies/latest
this will return a list of countries available for currency stuffs
**
*/
Route::get('/currencies/latest/batch', 'Api\CurrencyLatestController@batch');
Route::get('/currencies/latest','Api\CurrencyLatestController@index');
Route::get('/currencies/latest/{currency_code}','Api\CurrencyLatestController@show');

/*
**
handle routes with /currencies/convert
this will return a list of countries available for currency stuffs
**
*/
Route::get('/currencies/convert','Api\CurrencyConvertController@convert');