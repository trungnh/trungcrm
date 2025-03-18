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

    public function getListByRange($from, $to, $loggedUser)
    {
        $fromPath = explode('-', $from);
        $toPath = explode('-', $to);

        $fromY = $fromPath[0];
        $fromM = $fromPath[1];
        $toY = $toPath[0];
        $toM = $toPath[1];

        $inM = [];
        if ($fromY == $toY) {
            for($fm=$fromM; $fm<=$toM; $fm++) {
                $inM[] = $fromY . '-' . $fm;
            }
        } else {
            for($y=$fromY; $y<=$toY; $y++) {
                if ($y == $fromY) {
                    for($fm=$fromM; $fm<=12; $fm++) {
                        $inM[] = $y . '-' . $fm;
                    }
                }
                else if ($y == $toY) {
                    for($fm=1; $fm<=$toM; $fm++) {
                        $inM[] = $y . '-' . $fm;
                    }
                }
                else {
                    for($fm=1; $fm<=12; $fm++) {
                        $inM[] = $y . '-' . $fm;
                    }
                }
            }
        }
        
        if ($loggedUser->role == Constant::ROLE_ADMIN) {
            $collection = $this->model()
                ->whereIn('month', $inM)
                ->with('product', 'user');
        } else {
            $collection = $this->model()
                ->where('user_id', $loggedUser->id)
                ->whereIn('month', $inM)
                ->with('product', 'user');
        }
        
        $collection->orderBy('id', 'desc');
        $collection->orderBy('month', 'desc');

        return $collection->paginate(300);
    }

    public function getAllReports()
    {
        return $this->all();
    }
}
