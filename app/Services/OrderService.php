<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService extends Service
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * QueryService constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        OrderRepository $orderRepository
    ){
        $this->orderRepository = $orderRepository;
    }

    public function create($attributes)
    {
        return $this->orderRepository->create($attributes);
    }

    public function getList()
    {
        return $this->orderRepository->getList();
    }
}
