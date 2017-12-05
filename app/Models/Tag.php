<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title'
    ];

    /**
     * title局部作用域
     *
     * @param $query
     * @param $title
     * @return mixed
     */
    public function scopeTitle($query, $title)
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }
}
