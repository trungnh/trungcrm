<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;

class OrderItemService extends Service
{
    /**
     * @var OrderItemRepository
     */
    protected $orderItemRepository;

    /**
     * QueryService constructor.
     *
     * @param OrderItemRepository $orderItemRepository
     */
    public function __construct(
        OrderItemRepository $orderItemRepository
    ){
        $this->orderItemRepository = $orderItemRepository;
    }

    public function create($attributes)
    {
        return $this->orderItemRepository->create($attributes);
    }

    public function getList()
    {
        return $this->orderItemRepository->getList();
    }
}
