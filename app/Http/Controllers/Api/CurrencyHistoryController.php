<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Rate;

class CurrencyHistoryController extends Controller
{   

    public function findHistoryExchanges(Request $request)
    {
    	$currency_codes = ['USD'];
    	if($request->has('codes'))
    	{
    		$currency_codes = explode(',', $request->input('codes'));
    	}
    	$arr_count = count($currency_codes);
    	$date = '2019-01-01';
    	if($request->has('date'))
    	{
    		$date = $request->input('date');
    	}

    	$response = [
    		"success" => true,
    		"timestamp" => time(),
    		"date" => $date,
    		"exchange_type" => "historical",
    		"base" => "USD",    		
    	];
    	
    	
    	if($arr_count==1)
    	{    		
    		$country = Country::query()->where('currency_code','=',$currency_codes[0])->get();
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
    	}

    	else
    	{
    		$contentCollection = [$arr_count];   
			$country_id = [$arr_count];  

    		for($i=0; $i<$arr_count; $i++)
    		{  			  		
    			$country = Country::query()->where('currency_code','=',$currency_codes[$i])->get(); 
    			$country_id[$i] = $country[0]->id;
    			$rate = Rate::query()->where('recorded_date','=',$date)->where('country_id','=',$country_id[$i])->get();

    			$contentCollection[$i] = [
    				"rate" => $rate[0]->currency_rate,
    				'name' => $country[0]->currency_name,
					'code' => $country[0]->currency_code,
					'symbol' => $country[0]->currency_symbol,
					'country_code' => $country[0]->country_code,
    			];
    		}

    		$response += [
    			"currencies" => $contentCollection,
    			];
    	}

    	return response()->json($response)
         ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
           ]);

    }

    public function findSingleHistoryExchange(Request $request, $currency_code)
    {
    	$date = '2019-01-01';
    	if($request->has('date'))
    	{
    		$date = $request->input('date');
    	}

    	$response = [
    		"success" => true,
    		"timestamp" => time(),
    		"date" => $date,
    		"exchange_type" => "historical",
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
		return response()->json($response)
         ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
           ]);

    }
}