<?php

namespace App\Models;

class Report extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'user_id', 'name', 'month', 'return_rate', 'shipping_rate', 'product_unit_price', 'ads_tax_rate', 'ads_payment_fee', 'tax_rate', 'source', 'items'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
