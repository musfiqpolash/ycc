<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'product_requests';
}
