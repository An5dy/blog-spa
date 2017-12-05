<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class VerifyEmailCodeCriteria
 * @package namespace App\Criteria;
 */
class VerifyEmailCodeCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where([
            ['email', '=', request('email')],
            ['code', '=', request('captchaCode')],
        ]);

        return $model;
    }
}
