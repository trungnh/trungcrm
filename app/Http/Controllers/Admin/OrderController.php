<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OrderRequest;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * SampleController constructor.
     *
     * @param OrderService $orderService
     * @param ProductService $productService
     */
    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $orders = [];
        $products = $this->productService->getAllProducts();

        return view('admin.order.index', compact('orders', 'products'));
    }

    /**
     * @param OrderRequest $request
     * @return Factory|View
     */
    public function addOrder(OrderRequest $request)
    {
        $attributes = $request->all();
        $orderAttributes = $attributes['order'];
        $productAttributes = $attributes['product'];
        $orderAttributes['total'] = $productAttributes['price'];
        $orderAttributes = $attributes['order'];
        // TODO
        // Insert order & order item
        // Check customer exist, if not then insert
        var_dump($attributes);die;
    }
}
