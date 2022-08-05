<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
  protected $guarded = [];

  protected $table = 'order_details';

  function order() {
    return $this->belongsTo('App\Models\Order','ref_order');
  }
  function product() {
    return $this->belongsTo('App\Models\Product','ref_product');
  }
  function scancode() {
        return $this->hasOne('App\Models\ScanCode', 'ref_order_details');
    }

}
