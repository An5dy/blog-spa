<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TimeLimitCriteria
 * @package namespace App\Criteria;
 */
class TimeLimitCriteria implements CriteriaInterface
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
            ['created_at', '>', Carbon::today()],
            ['created_at', '<', Carbon::tomorrow()],
        ]);

        return $model;
    }
}
