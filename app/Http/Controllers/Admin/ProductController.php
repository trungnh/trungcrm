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
        $products = $this->productService->getList();

        return view('admin.product.index', compact('products'));
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
            echo $e->getMessage();die;
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
        }

        if ($product->id) {
            $response = [
                'name' => $product->name,
                'price' => $product->price,
                'fields' => $product->custom_fields,
            ];

            return response()->json(
                ['product' => $response, 'message' => trans('messages.admin.success.create', [], 'vi')],
                200
            );
        }

        return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
    }
}
