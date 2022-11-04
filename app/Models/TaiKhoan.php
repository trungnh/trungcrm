<?php

namespace App\Models;

class TaiKhoan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tai_khoan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uid', 'ten_tk', 'token', 'proxy', 'pass_proxy', 'agent', 'cookie'];
}
