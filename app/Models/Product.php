<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $guarded = [];

  protected $table = 'products';

  function brand() {
		return $this->belongsTo('App\Models\Brand','ref_brand');
	}
  function category() {
		return $this->belongsTo('App\Models\Category','ref_category');
	}
  function orderdetail() {
        return $this->hasOne('App\Models\OrderDetail', 'ref_product');
    }
    function stock() {
          return $this->hasOne('App\Models\Stock', 'ref_product');
      }
}
