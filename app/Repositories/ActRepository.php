<?php

namespace App\Repositories;

use App\Models\Act;

class ActRepository extends Repository
{
    /**
     * @var Act
     */
    protected $model = Act::class;

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

    public function getList($userId)
    {
        $collection = $this->model()->select(
            ['*']
        )->where('id', $userId);

        return $collection->paginate(10);
    }

    /**
     * @param $userId
     * @return \App\Models\Model[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getAllAct($userId)
    {
        return $this->model()->where('user_id', $userId)->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->find($id);
    }

    /**
     * @param string $actId
     * @return mixed
     */
    public function getByActId($actId)
    {
        return $this->model()->where('act_id', $actId)->first();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function deleteById(int $id)
    {
        return $this->delete($id);
    }
}
