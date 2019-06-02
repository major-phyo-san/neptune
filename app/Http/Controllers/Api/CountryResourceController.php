<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
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
        
        if($request->has('country_code'))
        {
            $countryCode = $request->input('country_code');
            $contentRaw = Country::query()->where('country_code','=',$countryCode)->get();            
            $content = new CountryResource($contentRaw);
            return $content;            
        }

        if($request->has('country_name'))
        {
            $countryName =  $request->input('country_name');
            $contentRaw = Country::query()->where('country_name', 'LIKE', "%{$countryName}%")->get();
            $content = new CountryResource($contentRaw);
            return $content;            
        }

        else
        {
           $contentRaw = Country::get();
           $content = new CountryResource($contentRaw);
           return $content;
                   
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
        $contentRaw = Country::query()->where('id','=',$id)->get();
        $content = new CountryResource($contentRaw);
        return $content; 
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
