<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OrderRequest;
use App\Services\OrderService;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\OrderItemService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var OrderItemService
     */
    private $orderItemService;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * SampleController constructor.
     *
     * @param OrderService $orderService
     * @param CustomerService $customerService
     * @param OrderItemService $orderItemService
     * @param ProductService $productService
     */
    public function __construct(
        OrderService $orderService,
        CustomerService $customerService ,
        OrderItemService $orderItemService,
        ProductService $productService
    )
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->orderItemService = $orderItemService;
        $this->productService = $productService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        $orders = $this->getCollection($this->orderService->getList());

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
        $customerAttributes = $attributes['customer'];
        $orderAttributes['total'] = $productAttributes['price'];
        $orderAttributes['ordered_date'] = date('Y-m-d');
        $customFields = json_decode($productAttributes['custom_fields']);
        $extraInfo = '';
        if (!empty($customFields)) {
            foreach ($customFields as $field) {
                $extraInfo .= $field->value . ' - ';
//                $extraInfo .= $field->label . ' - ' . $field->value;
            }
        }

        try {
            \DB::beginTransaction();
            $order = $this->orderService->create($orderAttributes);
            if ($order->id) {
                // Create order item
                $orderItemAttributes = [
                    'order_id' => $order->id,
                    'product_id' => $productAttributes['id'],
                    'product_name' => $productAttributes['name'],
                    'qty' => $orderAttributes['qty'],
                    'price' => $productAttributes['price'],
                    'total' => $order->total,
                    'extra_information' => trim($extraInfo, ' - '),
                ];
                $this->orderItemService->create($orderItemAttributes);

                // Create customer
                if (!isset($customerAttributes['id'])) {
                    $customerAttributes = [
                        'name' => $order->customer_name,
                        'phone' => $order->phone,
                        'address' => $order->address,
                        'note' => '',
                    ];

                    $customer = $this->customerService->create($customerAttributes);
                    // Save customer id to order
                    if ($customer->id) {
                        $order->customer_id = $customer->id;
                        $order->save();
                    }
                }
            }
            \DB::commit();
        }catch(\Exception $e){
            echo $e->getMessage();die;
            \DB::rollback();
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
        }

        return response()->json(
            ['order' => $order, 'message' => trans('messages.admin.success.create', [], 'vi')],
            200
        );
    }
}
