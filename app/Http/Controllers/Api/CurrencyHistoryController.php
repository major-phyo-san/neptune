<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Rate;


class CurrencyHistoryController extends Controller
{
    public function index(Request $request)
    {
        $response = [];
        $successFlag = true;

        $date = '2019-01-01';
        if($request->has('date'))
        {
            $date = $request->input('date');
        }

        $response = [
            "success"=> $successFlag,
            "timestamp"=>time(),
            "date"=>$date,
            "exchange_type"=>"historical",
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
        $date = '2019-01-01';
        if($request->has('date'))
        {
            $date = $request->input('date');
        }

        $response = [
            "success"=> $successFlag,
            "timestamp"=>time(),
            "date"=>$date,
            "exchange_type"=>"historical",
            "base"=>"USD",
        ];

        $country = Country::query()->where('currency_code','=',$currency_code)->get()[0];
        $country_id = $country->id;    
        $rate = Rate::query()->where('recorded_date','=',$date)->where('country_id','=',$country_id)->get()[0];

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
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
        ]);

    }

    public function batch(Request $request)
    {
        $successFlag = true;
        $currency_codes = ['USD','MMK'];
        if($request->has('codes'))
        {
            $currency_codes = explode(',', $request->input('codes'));
        }
        $date = '2019-01-01';
        if($request->has('date'))
        {
            $date = $request->input('date');
        }

        $response = [
            "success"=> $successFlag,
            "timestamp"=>time(),
            "date"=>$date,
            "exchange_type"=>"historical",
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
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
        ]);

    }

}