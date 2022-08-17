<?php

namespace App\Models;

class Act extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'act';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['act_name', 'act_id', 'token', 'active', 'user_id', 'cookie'];
}
