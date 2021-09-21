<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends Repository
{
    /**
     * @var Order
     */
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getList()
    {
        $collection = $this->model->select(['orders.*'])->with(['customer', 'order_items']);

        return $collection->paginate(30);
    }
}
