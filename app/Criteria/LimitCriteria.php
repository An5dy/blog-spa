<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LimitCriteria
 * @package namespace App\Criteria;
 */
class LimitCriteria implements CriteriaInterface
{
    protected $limit;

    /**
     * 设置查询限制
     *
     * LimitCriteria constructor.
     * @param $limit
     */
    public function __construct($limit)
    {
        $this->limit = $limit;
    }

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
        $model = $model->limit($this->limit);

        return $model;
    }
}
