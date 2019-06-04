<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    public $visible = ['id','country_name','country_code','currency_name','currency_code','currency_symbol'];

    public $fillable = ['country_name','country_code','currency_name','currency_code','currency_symbol'];

    public function rates()
    {
    	return $this->hasMany(Rate::class);
    }
}
