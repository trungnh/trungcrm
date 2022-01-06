<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    /**
     * @var User
     */
    protected $model;

    /**
     * QueryService constructor.
     *
     * @param User $model
     */
    public function __construct(
        User $model
    ){
        $this->model = $model;
    }

    public function getAllUser()
    {
        return $this->model->get();
    }

    public function getById($userId)
    {
        return $this->model->findOrFail($userId);
    }
}
