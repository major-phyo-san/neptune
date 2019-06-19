<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = [
            "success" => true,
            "timestamp" => time()
        ];
        
        if($request->has('country_code'))
        {
            $countryCode = $request->input('country_code');
            $content = Country::query()->where('country_code','=',$countryCode)->get();           
            $response += [
                "countries" => $content
            ]; 
            return response()->json($response)
            ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
           ]);               
        }

        if($request->has('country_name'))
        {
            $countryName =  $request->input('country_name');
            $content = Country::query()->where('country_name', 'LIKE', "%{$countryName}%")->get();
            $response += [
                "countries" => $content
            ]; 
            return response()->json($response)
            ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
           ]);    
        }

        else
        {
           $content = Country::get();
           $response += [
                "countries" => $content
            ];
           
           return response()->json($response)
           ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
           ]);
                   
        }


    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Country::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $response = [
            "success" => true,
            "timestamp" => time()
        ];
        $content = Country::findOrFail($id);
        $response += [
                "countries" => $content
            ]; 
        return response()->json($response)
        ->withHeaders([
            "Content-Type" => 'application/json; charset=utf-8',
            "Access-Control-Allow-Origin" => '*',
           ]);    
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
        $country = Country::findOrFail($id);
        $country->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $country = Country::findOrFail($id);
        $country->delete();
    }
}