<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CustomerRequest;
use App\Services\CustomerService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * SampleController constructor.
     *
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
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
     * @param CustomerRequest $request
     * @return Factory|View
     */
    public function getCustomer(CustomerRequest $request)
    {
        $attributes = $request->all();

        try {
            $customer = $this->customerService->findByPhone($attributes['phone']);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
        }

        if ($customer) {
            return response()->json(
                ['customer' => $customer],
                200
            );
        }

        return response()->json(
            ['customer' => []],
            200
        );
    }
}
