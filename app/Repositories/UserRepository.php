<?php

namespace App\Repositories;

use App\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * 设置model
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}