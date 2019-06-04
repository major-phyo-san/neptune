<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Rate;

class CurrencyHistoryController extends Controller
{
    public function findExchange(Request $request)
    {
    	$currency_code = 'USD';
    	if($request->has('code'))
    	{
    		$currency_code = $request->input('code');
    	}
    	$date = '2019-01-01';
    	if($request->has('date'))
    	{
    		$date = $request->input('date');
    	}

    	$response = [
    		"success" => true,
    		"timestamp" => time(),
    		"date" => $date,
    		"historical" => true,
    		"base" => "USD",
    	];
    	

    	$country = Country::query()->where('currency_code','=',$currency_code)->get();
		$country_id = $country[0]->id;	
	
		$rate = Rate::query()->where('recorded_date','=',$date)->where('country_id','=',$country_id)->get();	

		
			
		$response += [
			'currency' => [
				'rate' => $rate[0]->currency_rate,
				'name' => $country[0]->currency_name,
				'code' => $country[0]->currency_code,
				'symbol' => $country[0]->currency_symbol,
				'country_code' => $country[0]->country_code,
							],
					];
		return response()->json($response);
		
    }

}
