<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanCode extends Model
{
  protected $guarded = [];

  protected $table = 'sacn_codes';

  function order() {
    return $this->belongsTo('App\Models\Order','ref_order');
  }
  function orderdetail() {
    return $this->belongsTo('App\Models\OrderDetail','ref_order_details');
  }
}
