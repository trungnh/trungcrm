<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductRequest;
use App\Services\ProductService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * SampleController constructor.
     *
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $loggedUser = auth()->user();
        $products = $this->productService->getList();

        return view('admin.product.index', compact('products', 'loggedUser'));
    }

    /**
     * @param ProductRequest $request
     * @return Factory|View
     */
    public function addProduct(ProductRequest $request)
    {
        $attributes = $request->all();

        try {
            $product = $this->productService->create($attributes);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi') . $e->getMessage()], 202);
        }

        if ($product->id) {
            $response = [
                'name' => $product->name,
                'keyword' => $product->keyword,
                'price' => $product->price,
                'unit_price' => $product->unit_price,
                'shipping_price' => $product->shipping_price,
                'return_rate' => $product->return_rate,
            ];

            return response()->json(
                ['product' => $response, 'message' => trans('messages.admin.success.create', [], 'vi')],
                200
            );
        }

        return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
    }
}
