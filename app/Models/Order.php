<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $guarded = [];

  protected $table = 'orders';

  function orderdetail() {
        return $this->hasOne('App\Models\OrderDetail', 'ref_order');
    }

  function scancode() {
        return $this->hasOne('App\Models\ScanCode', 'ref_order');
    }

  function customer() {
    return $this->belongsTo('App\Models\Customer','ref_customer');
  }
}
