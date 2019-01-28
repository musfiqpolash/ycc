<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerMessage extends Model
{
    protected $fillable = [
        'name', 'email', 'subject', 'message',
    ];
}
