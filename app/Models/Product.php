<?php

namespace App\Models;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'keyword', 'price', 'unit_price', 'shipping_price', 'return_rate','custom_fields'];
}
