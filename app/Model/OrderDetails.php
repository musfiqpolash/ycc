<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
   protected $table = 'order_details';

   public function hasProduct()
   {
      return $this->belongsTo('App\Model\Product', 'p_id');
   }
}
