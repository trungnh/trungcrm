<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends Service
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * QueryService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    ){
        $this->userRepository = $userRepository;
    }

    public function getAllUser()
    {
        return $this->userRepository->getAllUser();
    }

    public function getById($userId)
    {
        return $this->userRepository->getById($userId);
    }
}
