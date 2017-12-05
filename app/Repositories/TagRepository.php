<?php

namespace App\Repositories;

use App\Models\Tag;
use Prettus\Repository\Eloquent\BaseRepository;

class TagRepository extends BaseRepository
{
    public function model()
    {
        return Tag::class;
    }
}