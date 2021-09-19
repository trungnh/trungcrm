<?php

namespace App\Repositories;

use App\Models\Sample;

class SampleRepository extends Repository
{
    /**
     * @var Sample
     */
    protected $model = Sample::class;

    /**
     * get top ten items
     *
     * @param array $fields
     * @return mixed
     * @throws \Exception
     */
    public function getTop($fields = ['*'])
    {
        return $this->model()->limit(10)->get($fields);
    }
}
