<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product_info';

    public function hasImage()
    {
        return $this->hasMany('App\Model\ProductImage', 'product_id');
    }

    public function hasPrice()
    {
        return $this->hasMany('App\Model\ProductPrice', 'product_id');
    }

    public function hasPriceList()
    {
        return $this->hasMany('App\Model\ProductPrice', 'product_id');
    }

    public function hasSinglePrice()
    {
        return $this->hasOne('App\Model\ProductPrice', 'product_id')
            ->where('min_quantity', 1)
            ->where('max_quantity', 1);
    }

    public function hasCategory()
    {
        return $this->belongsTo('App\Category', 'category');
    }

    public function hasSubCategory()
    {
        return $this->belongsTo('App\SubCategory', 'sub_category_id');
    }
}
