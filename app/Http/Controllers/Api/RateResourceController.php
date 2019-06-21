<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Rate;
use Carbon\Carbon;

class RateResourceController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();
        $date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');

        $content = Rate::get();  
        return $this->sendResponse($date,"Liting all rates","rates",$content);
    }

    public function show($id)
    {
        $now = Carbon::now();
        $date = $now->format('Y').'-'.$now->format('m').'-'.$now->format('d');
             
        $content = Rate::findOrFail($id);
        return $this->sendResponse($date,"Get a single rate by ID","rate",$content);
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            "country_id"=>"required",
            "recorded_date"=>"required",
            "currency_rate"=>"required",
        ]);
        if($validator->fails())
        {
            return redirect()->route(null,[],400);
        }
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
