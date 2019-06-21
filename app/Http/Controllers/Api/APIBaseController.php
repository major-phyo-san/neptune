<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

/**
 * 
 */
class APIBaseController extends Controller
{
	
	public function sendResponse($date,$exchange_type,$response_description,$content)
	{
		$response = [
			"success"=>true,
			"timestamp"=>time(),
			"date"=>$date,
			"exchange_type"=>$exchange_type,
			"base"=>"USD",
			$response_description=>$content,
		];

		return response()->json($response)
		->withHeaders([
            "Content-Type"=>"application/json; charset=utf-8",
            "Access-Control-Allow-Origin"=>"*"
        ]);
	}
}