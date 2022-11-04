<?php

namespace App\Services;

use App\Repositories\TaiKhoanRepository;

class TaiKhoanService extends Service
{
    /**
     * @var TaiKhoanRepository
     */
    protected $taiKhoanRepository;

    /**
     * QueryService constructor.
     *
     * @param $taiKhoanRepository $taiKhoanRepository
     */
    public function __construct(
        TaiKhoanRepository $taiKhoanRepository
    ){
        $this->taiKhoanRepository = $taiKhoanRepository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->taiKhoanRepository->getById($id);
    }

    /**
     * @param string $uId
     * @return mixed
     */
    public function getByUId($uId)
    {
        return $this->taiKhoanRepository->getByBusinessId($uId);
    }
}
