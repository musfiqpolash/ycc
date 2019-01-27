<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public function scopeIsBanner($q)
    {
        return $q->where('type', 'banner');
    }
    public function scopeIsBrand($q)
    {
        return $q->where('type', 'brand');
    }
}
