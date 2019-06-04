<?php

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Country;
use App\Models\Rate;

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
Route::post('/rates/store', 'Api\RateResourceController@store');
Route::put('/rates/update/{id}', 'Api\RateResourceController@update');

/*
**
handle routes with /currencies/history
this will return a list of countries available for currency stuffs
**
*/
Route::get('/currencies/history','Api\CurrencyHistoryController@findExchange');


Route::get('/currencies/test', function(Request $request){
	if($request->has('list'))
	{
		$word_arr = explode(',', $request->input('list'));
		return $word_arr[0];
	}
});