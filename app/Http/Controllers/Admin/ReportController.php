<?php

namespace App\Http\Controllers\Admin;

use App\Constant;
use App\Http\Requests\Admin\ReportRequest;
use App\Models\Report;
use App\Services\ProductService;
use App\Services\ReportService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * @var ReportService
     */
    private $reportService;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * SampleController constructor.
     *
     * @param ReportService $reportService
     * @param ProductService $productService
     */
    public function __construct(ReportService $reportService, ProductService $productService)
    {
        $this->reportService = $reportService;
        $this->productService = $productService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $loggedUser = auth()->user();

        $months = $this->reportService->getMonths();
        $reports = $this->reportService->getList($loggedUser);
        $monthsInFilter = [];
        $usersInFilter = [];
        $productsInFilter = [];
        foreach ($reports as &$report) {
            $report['items'] = unserialize($report['items']);
            $monthsInFilter[$report['month']] = $report['month'];
            $productsInFilter[$report['product']['name']] = $report['product']['name'];
            $usersInFilter[$report['user']['name']] = $report['user']['name'];
        }
        $products = $this->productService->getList();
        $sources = Constant::SOURCE;

        return view('admin.report.index', compact('reports', 'products', 'months', 'sources', 'loggedUser', 'monthsInFilter', 'usersInFilter', 'productsInFilter'));
    }

    public function edit($id)
    {
        $report = $this->reportService->getById($id);

        return view('admin.report.edit', compact('report'));
    }

    /**
     * @param ReportRequest $request
     * @return Factory|View
     */
    public function addReport(ReportRequest $request)
    {
        $attributes = $request->all();

        try {
            $loggedUserId = auth()->user()->id;

            $product = $this->productService->getById($attributes['product_id']);
            $attributes['user_id'] = $loggedUserId;
            $attributes['return_rate'] = $product->return_rate;
            $attributes['shipping_rate'] = $product->shipping_price;
            $attributes['product_unit_price'] = $product->unit_price;
            $attributes['tax_rate'] = Constant::TAX_RATE;
            $attributes['name'] = $attributes['source'] . ' - ' . $product->name . ' Tháng ' . date('m', strtotime($attributes['month'] . '-1'));
            //Create all item in month
            $items = [];
            $currentMonth = date('Y-m', strtotime($attributes['month'] . '-1'));
            $lastDayOfMonth = date('t', strtotime($currentMonth));
            for ($i=1; $i<=$lastDayOfMonth; $i++) {
                $items[] = [
                    'date' => $currentMonth . '-' . $i,
                    'orders' => 0,
                    'product_qty' => 0,
                    'ads_amount' => 0,
                    'revenue' => 0,
                    'totalUnitPrice' => 0,
                    'totalShippingPrice' => 0,
                    'totalReturnPrice' => 0,
                    'totalSpent' => 0,
                    'profit' => 0,
                    'cpa' => 0,
                    'profitPerOrder' => 0,
                    'adsRate' => 0,
                    'roas' => 0,
                ];
            }

            $attributes['items'] = serialize($items);
            $report = $this->reportService->create($attributes);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi') . $e->getMessage()], 202);
        }

        if ($report->id) {
            $report->product->name = $product->name;
            return response()->json(
                ['report' => $report, 'message' => trans('messages.admin.success.create', [], 'vi')],
                200
            );
        }

        return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
    }

    /**
     * @param ReportRequest $request
     * @param int $id
     * @return Factory|View
     */
    public function saveReport(ReportRequest $request, $id)
    {
        $attributes = $request->all();

        $attributes['items'] = serialize($attributes['items']);
        $report = Report::find($id);
        $report->fill($attributes);

        $report->save();

        return response()->json(
            ['message' => trans('messages.admin.success.update', [], 'vi')],
            200
        );
    }
}
