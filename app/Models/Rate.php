<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    //
    protected $visible = ['country_id','recorded_date','currency_rate'];

    protected $fillable = ['country_id','recorded_date','currency_rate'];
}
