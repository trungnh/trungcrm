<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends Repository
{
    /**
     * @var Product
     */
    protected $model = Product::class;

    /**
     * get top ten items
     *
     * @param array $fields
     * @return mixed
     * @throws \Exception
     */
    public function getTop($fields = ['*'])
    {
        return $this->model()->limit(20)->get($fields);
    }

    public function getList()
    {
        $collection = $this->model()->select(
            ['*']
        );

        return $collection->paginate(20);
    }

    public function getAllProducts()
    {
        return $this->all();
    }
}
