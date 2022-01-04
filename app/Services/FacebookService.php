<?php

namespace App\Services;

class FacebookService extends Service
{
    public function __construct(){
    }

    public function create($attributes)
    {
        return $this->bmRepository->create($attributes);
    }

    public function getList()
    {
        return $this->bmRepository->getList();
    }

    public function getAllBms()
    {
        return $this->bmRepository->getAllBms();
    }
}
