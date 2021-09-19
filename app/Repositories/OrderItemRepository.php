<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends Repository
{
    /**
     * @var OrderItemRepository
     */
    protected $model = OrderItemRepository::class;

    public function getList()
    {
        $collection = $this->model()->select(
            ['*']
        );

        return $collection->paginate(5);
    }
}
