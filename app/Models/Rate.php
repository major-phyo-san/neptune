<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    //
    public $visible = ['country_id','recorded_date','currency_rate'];

    public $fillable = ['country_id','recorded_date','currency_rate'];

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }
}
