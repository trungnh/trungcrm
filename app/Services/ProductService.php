<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService extends Service
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * QueryService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductRepository $productRepository
    ){
        $this->productRepository = $productRepository;
    }

    public function create($attributes)
    {
        $attributes['custom_fields'] = json_encode($attributes['fields']);
        unset($attributes['fields']);

        return $this->productRepository->create($attributes);
    }

    public function getList()
    {
        return $this->productRepository->getList();
    }
}
