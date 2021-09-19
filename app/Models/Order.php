<?php

namespace App\Models;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'customer_name', 'phone', 'address', 'note', 'total', 'ordered_date'];
}
