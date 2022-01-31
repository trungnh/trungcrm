<?php

namespace App\Repositories;

use App\Models\Bm;

class BmRepository extends Repository
{
    /**
     * @var Bm
     */
    protected $model = Bm::class;

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
    public function getAllBms($userId)
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
     * @param string $bmId
     * @return mixed
     */
    public function getByBusinessId($bmId)
    {
        return $this->model()->where('business_id', $bmId)->first();
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
