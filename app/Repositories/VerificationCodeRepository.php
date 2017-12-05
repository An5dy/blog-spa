<?php

namespace App\Repositories;

use App\Models\VerificationCode;
use Prettus\Repository\Eloquent\BaseRepository;

class VerificationCodeRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return VerificationCode::class;
    }

    /**
     * 返回条数
     *
     * @return mixed
     */
    public function count()
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->count();

        $this->resetModel();

        return $this->parserResult($results);
    }
}