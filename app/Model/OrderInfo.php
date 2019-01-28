<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $table = 'order_info';

    public function hasOrderDetails()
    {
        return $this->hasMany('App\Model\OrderDetails', 'order_id');
    }
    public function hasPayment()
    {
        return $this->belongsTo('App\Model\PaymentInfo', 'payment_id');
    }

    public function clients()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }
}
