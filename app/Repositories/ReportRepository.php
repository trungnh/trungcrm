<?php

namespace App\Repositories;

use App\Constant;
use App\Models\Report;

class ReportRepository extends Repository
{
    /**
     * @var Report
     */
    protected $model = Report::class;

    /**
     * get top ten items
     *
     * @param array $fields
     * @return mixed
     * @throws \Exception
     */
    public function getTop($fields = ['*'])
    {
        return $this->model()->get($fields);
    }

    public function getList($loggedUser)
    {
        if ($loggedUser->role == Constant::ROLE_ADMIN) {
            $collection = $this->model()->with('product');
        } else {
            $collection = $this->model()->where('user_id', $loggedUser->id)->with('product');
        }

        return $collection->paginate(50);
    }

    public function getAllReports()
    {
        return $this->all();
    }
}
