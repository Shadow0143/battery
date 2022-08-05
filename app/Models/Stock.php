<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
  protected $guarded = [];

  protected $table = 'stocks';

  function Stockdetail() {
    return $this->belongsTo('App\Models\StockDeatil','ref_stock_detail');
  }
  function product() {
    return $this->belongsTo('App\Models\Product','ref_product');
  }
}
