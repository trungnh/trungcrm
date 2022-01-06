<?php

namespace App\Models;

class Bm extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bm';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['business_name', 'business_id', 'token', 'active', 'user_id'];
}
