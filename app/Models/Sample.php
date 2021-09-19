<?php

namespace App\Models;

class Sample extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sample';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content'];
}
