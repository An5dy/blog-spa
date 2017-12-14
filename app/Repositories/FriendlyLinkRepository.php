<?php

namespace App\Repositories;

use App\Models\FriendlyLink;
use Prettus\Repository\Eloquent\BaseRepository;

class FriendlyLinkRepository extends BaseRepository
{
    public function model()
    {
        return FriendlyLink::class;
    }
}