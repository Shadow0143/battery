<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $guarded = [];

	protected $table = 'categories';

  function product() {
        return $this->hasOne('App\Models\Product', 'ref_category');
    }
}
