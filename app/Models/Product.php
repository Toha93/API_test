<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function cart()
    {
        return $this->belongsTo('App\Models\CartItems', 'product_slug', 'slug');
    }

        public function characteristics()
    {
        return $this->hasOne('App\Models\Characteristics', 'product_slug', 'slug');
    }

}
