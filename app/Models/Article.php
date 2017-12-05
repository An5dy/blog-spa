<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'description', 'category_id'
    ];

    /**
     * 修改时间显示
     *
     * @param $value
     * @return false|string
     */
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    /**
     * 文章作者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * 文章所属分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
     * 文章所属标签
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    /**
     * 文章分类作用域
     *
     * @param $query
     * @param $category_id
     * @return mixed
     */
    public function scopeCategory($query, $category_id)
    {
        return isset($category_id) ? $query->where('category_id', $category_id) : $query;
    }

    /**
     * 文章作者作用域
     *
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeAuthor($query, $user_id)
    {
        return isset($user_id) ? $query->where('user_id', $user_id) : $query;
    }

    /**
     * 文章搜索
     *
     * @param $query
     * @param $title
     * @return mixed
     */
    public function scopeTitle($query, $title)
    {
        return isset($title) ? $query->where('title', 'like', '%' . $title . '%') : $query;
    }
}
