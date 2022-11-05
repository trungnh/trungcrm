<?php

namespace App\Repositories;

use App\Models\TaiKhoan;

class TaiKhoanRepository extends Repository
{
    /**
     * @var TaiKhoan
     */
    protected $model = TaiKhoan::class;

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
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->find($id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getByUserId($id)
    {
        return $this->model()->where('user_id', $id)->first();
    }

    /**
     * @param string $uId
     * @return mixed
     */
    public function getByUId($uId)
    {
        return $this->model()->where('uid', $uId)->first();
    }
}
