<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends Repository
{
    /**
     * @var Order
     */
    protected $model = Order::class;

    public function getList()
    {
        $collection = $this->model()->select(
            ['*']
        );

        return $collection->paginate(5);
    }
}
