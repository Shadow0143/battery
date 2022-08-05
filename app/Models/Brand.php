<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  protected $guarded = [];

  protected $table = 'brands';

  function product() {
        return $this->hasOne('App\Models\Product', 'ref_brand');
    }

}
 
