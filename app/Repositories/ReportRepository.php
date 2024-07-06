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
            $collection = $this->model()->with('product', 'user');
        } else {
            $collection = $this->model()->where('user_id', $loggedUser->id)->with('product', 'user');
        }

        $collection->orderBy('id', 'desc');
        $collection->orderBy('month', 'desc');

        return $collection->paginate(50);
    }

    public function getListByMonth($month, $loggedUser)
    {
        if ($loggedUser->role == Constant::ROLE_ADMIN) {
            $collection = $this->model()
                ->where('month', $month)
                ->with('product', 'user');
        } else {
            $collection = $this->model()
                ->where('user_id', $loggedUser->id)
                ->where('month', $month)
                ->with('product', 'user');
        }
        
        $collection->orderBy('id', 'desc');
        $collection->orderBy('month', 'desc');
        return $collection->paginate(50);
    }

    public function getAllReports()
    {
        return $this->all();
    }
}
