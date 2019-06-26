<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Rate;
use Carbon\Carbon;

class CurrencyConvertController extends APIBaseController
{
    //
    public function convert(Request $request)    
    {
        $from_currency_code = 'USD';
        $to_currency_code = 'MMK';
        $amount = 1.0;
        $now = Carbon::now();
        $date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');
        if($request->has('to'))
        {
            $to_currency_code = $request->input('to');
            if($request->has('from'))
            {
                $from_currency_code = $request->input('from');
            }
        }
        if($request->has('amount'))
        {
            $amount = $request->input('amount');
        }
        if($request->has('date'))
        {
            $date = $request->input('date');
        }

        //getting required currency
        $from_country = Country::query()
        ->where('currency_code','=',$from_currency_code)->get()[0];

        $from_rate_collection = Rate::query()
        ->where('recorded_date','=',$date)
        ->where('country_id','=',$from_country->id)->get()[0];

        $from_rate = $from_rate_collection->currency_rate; //required currency rate

        //getting target currency
        $to_country = Country::query()
        ->where('currency_code','=',$to_currency_code)->get()[0];
        $to_rate_collection = Rate::query()
        ->where('recorded_date','=',$date)
        ->where('country_id','=',$to_country->id)->get()[0];
        $to_rate = $to_rate_collection->currency_rate;  //target currency rate

        $result = round(($amount/$from_rate)*$to_rate, 3); //convert the required currency to target currency, round to 3 decimal places

        $content = [
                "from" => $from_currency_code,
                "to" => $to_currency_code,
                "amount" => $amount,
                "result" => $result,
        ];

        return $this->sendResponse($date,"conversion","convert",$content);
    }
}