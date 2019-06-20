<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rate;

class RateResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $response = [
            "success"=>true,
            "timestamp"=>time(),
            "exchange_type"=>"Recorded rates",
            "message"=>"you must specify date in YYYY-DD-MM format",
        ];
        $content = Rate::get();

        $response += [
            "recorded_rates"=>$content,
        ];
        return response()->json($response)
        ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
        ]);  
    }

    public function show($id)
    {
        //
        $response = [
            "success" => true,
            "timestamp" => time(),
            "exchange_type"=>"Recorded rates",
            "message"=>"you must specify date in YYYY-DD-MM format",
        ];        
        $content = Rate::findOrFail($id);

        $response += [
                "recorded_rates" => $content
        ];
        return response()->json($response)
        ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
        ]);    
    }

    
    public function store(Request $request)
    {
        //
        Rate::create($request->all());
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rate = Rate::findOrFail($id);
        $rate->update($request->all());
    }

    public function destroy($id)
    {
        $rate = Rate::findOrFail($id);
        $rate->delete();
    }
    
}
