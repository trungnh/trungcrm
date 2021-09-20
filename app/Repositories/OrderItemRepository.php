<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends Repository
{
    /**
     * @var OrderItem
     */
    protected $model = OrderItem::class;

    public function getList()
    {
        $collection = $this->model()->select(
            ['*']
        );

        return $collection->paginate(5);
    }
}
