<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;


abstract class Controller extends BaseController
{
    /**
     * Paginate collection
     *
     * @param array $attribute
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getCollection($collection)
    {
        return [
            'pagination' => [
                'total' => $collection->total(),
                'per_page' => $collection->perPage(),
                'current_page' => $collection->currentPage(),
                'last_page' => $collection->lastPage(),
                'from' => $collection->firstItem(),
                'to' => $collection->lastItem()
            ],
            'data' => $collection->items()
        ];
    }
}
