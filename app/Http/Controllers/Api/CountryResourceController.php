<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Country;
use Carbon\Carbon;

class CountryResourceController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');

        if($request->has('country_code'))
        {
            $countryCode = $request->input('country_code');
            $content = Country::query()->where('country_code','=',$countryCode)->get();           
            return $this->sendResponse($date,"Find country","country",$content);
        }

        if($request->has('country_name'))
        {
            $countryName =  $request->input('country_name');
            $content = Country::query()->where('country_name', 'LIKE', "%{$countryName}%")->get();
            return $this->sendResponse($date,"Find Country","countries",$content);    
        }

        else
        {
           $content = Country::get();
           return $this->sendResponse($date,"Listing Countres","countries",$content);
                   
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
        $input = $request->all();
        $validator = Validator::make($input,[
            "country_name"=>"required",
            "country_code"=>"required",
            "currency_name"=>"required",
            "currency_code"=>"required",
        ]);
        if($validator->fails())
        {
            return redirect()->route(null,[],400);
        }
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
        $now = Carbon::now();
        $date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');
        $content = Country::findOrFail($id);
        return $this->sendResponse($date,"Get a single country by ID","country",$content);
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