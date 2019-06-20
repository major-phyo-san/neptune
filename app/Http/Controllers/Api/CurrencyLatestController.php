<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Rate;
use Carbon\Carbon;

class CurrencyLatestController extends Controller
{  
	public function index(Request $request)
    {
<<<<<<< HEAD
    	$currency_codes = ['USD'];
    	if($request->has('codes'))
    	{
    		$currency_codes = explode(',', $request->input('codes'));
    	}
    	$arr_count = count($currency_codes);
    	$now = Carbon::now();
    	$date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');   	
    	
    	$response = [
    		"success" => true,
    		"timestamp" => time(),
    		"date" => $date,
    		"exchange_type" => "latest",
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
=======
        $response = [];
        $successFlag = true;

        $now = Carbon::now();
    	$date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');

        $response = [
            "success"=> $successFlag,
            "timestamp"=>time(),
            "date"=>$date,
            "exchange_type"=>"latest",
            "base"=>"USD",
        ];

        $countryCount = count(Country::get());
        $contentCollection = [$countryCount];        
        
        for($i=1;$i<=$countryCount;$i++)
        {
            $country = Country::findOrFail($i);
            $rate = Rate::query()
            ->where('recorded_date','=',$date)
            ->where('country_id','=',$country->id)->get()[0];           
          
            $contentCollection[$i-1] = [
                "rate" => $rate->currency_rate,
                "name"=> $country->currency_name,
                "code"=>$country->currency_code,
                "symbol" => $country->currency_symbol,
            ];            
        }

        $response += [
            "currencies"=>$contentCollection,
        ];

        return response()->json($response)
        ->withHeaders([
            "Content-Type"=>"application/json; charset=utf-8",
            "Access-Control-Allow-Origin"=>"*"
        ]);
    }

    public function show(Request $request, $currency_code)
    {
        $successFlag = true;
        $now = Carbon::now();
    	$date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');

        $response = [
            "success"=> $successFlag,
            "timestamp"=>time(),
            "date"=>$date,
            "exchange_type"=>"latest",
            "base"=>"USD",
        ];

        $country = Country::query()->where('currency_code','=',$currency_code)->get()[0];
        $country_id = $country->id;    
        $rate = Rate::query()
        ->where('recorded_date','=',$date)
        ->where('country_id','=',$country_id)->get()[0];

        $response += [
            "currency" => [
                "rate" => $rate->currency_rate,
                "name" => $country->currency_name,
                "code" => $country->currency_code,
                "symbol" => $country->currency_symbol,
                "country_code" => $country->country_code,
                ],
        ];  

        return response()->json($response)
         ->withHeaders([
>>>>>>> side-branch
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
        ]);

    }

    public function batch(Request $request)
    {
<<<<<<< HEAD
    	$now = Carbon::now();
    	$date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');   	
    	
    	$response = [
    		"success" => true,
    		"timestamp" => time(),
    		"date" => $date,
    		"exchange_type" => "latest",
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
=======
        $successFlag = true;
        $currency_codes = ['USD','MMK'];
        if($request->has('codes'))
        {
            $currency_codes = explode(',', $request->input('codes'));
        }
        $now = Carbon::now();
    	$date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');

        $response = [
            "success"=> $successFlag,
            "timestamp"=>time(),
            "date"=>$date,
            "exchange_type"=>"latest",
            "base"=>"USD",
        ];

        $arr_count = count($currency_codes);
        $contentCollection = [$arr_count];
        $country_id = [$arr_count];

        for($i=0; $i<$arr_count; $i++)
        {                   
            $country = Country::query()->where('currency_code','=',$currency_codes[$i])->get()[0]; 
            $country_id[$i] = $country->id;
            $rate = Rate::query()
            ->where('recorded_date','=',$date)
            ->where('country_id','=',$country_id[$i])->get()[0];

            $contentCollection[$i] = [
                "rate" => $rate->currency_rate,
                "name" => $country->currency_name,
                "code" => $country->currency_code,
                "symbol" => $country->currency_symbol,
                "country_code" => $country->country_code,
            ];
        }

        $response += [
                "currencies" => $contentCollection,
        ];

        return response()->json($response)
         ->withHeaders([
>>>>>>> side-branch
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
        ]);

    }

}