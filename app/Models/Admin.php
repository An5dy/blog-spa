<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'level'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];
}
