<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDetail extends Model
{
    protected $guarded = [];

    protected $table = 'stock_details';

    function stock() {
        return $this->hasOne('App\Models\Stock', 'ref_stock_detail');
    }

    function customer() {
        return $this->belongsTo('App\Models\Customer','ref_customer');
    }

}
