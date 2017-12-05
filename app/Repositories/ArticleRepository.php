<?php

namespace App\Repositories;

use App\Models\Article;
use Prettus\Repository\Eloquent\BaseRepository;

class ArticleRepository extends BaseRepository
{
    /**
     * 模型
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }
}