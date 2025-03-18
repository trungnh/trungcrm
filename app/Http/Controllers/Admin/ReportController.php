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
        $month = request()->query('month');
        $from = $month = request()->query('from');
        $to = $month = request()->query('to');
        if (!is_null($from)) {
            extract($this->getListByRange($from, $to));
        } else {
            extract($this->getListReports($month));
        }

        $products = $this->productService->getList();
        $sources = Constant::SOURCE;

        return view('admin.report.index', compact('reports', 'month', 'from', 'to', 'products', 'months', 'sources', 'loggedUser', 'monthsInFilter', 'usersInFilter', 'productsInFilter'));
    }

    public function edit($id)
    {
        $loggedUser = auth()->user();
        $report = $this->reportService->getById($id);

        return view('admin.report.edit', compact('report', 'loggedUser'));
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

            if ($attributes['source'] == 'Google') {
                $attributes['ads_tax_rate'] = Constant::GG_ADS_TAX_RATE;
            } else if ($attributes['source'] == 'Tiktok') {
                $attributes['ads_tax_rate'] = Constant::TT_ADS_TAX_RATE;
            }
            else if ($attributes['source'] == 'Facebook') {
                $attributes['ads_tax_rate'] = Constant::FB_ADS_TAX_RATE;
            }

            $attributes['tax_rate'] = Constant::TAX_RATE;
            $attributes['ads_payment_fee'] = Constant::ADS_PAYMENT_FEE;

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

            extract($this->getListReports());
            return response()->json(
                ['data' => compact('report', 'reports', 'monthsInFilter', 'usersInFilter', 'productsInFilter'), 'message' => trans('messages.admin.success.create', [], 'vi')],
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

    protected function getListReports($month = null)
    {
        $loggedUser = auth()->user();
        if (!is_null($month)) {
            $reports = $this->reportService->getListByMonth($month, $loggedUser);
        } else {
            $reports = $this->reportService->getList($loggedUser);
        }

        $months = $this->reportService->getMonths();

        $monthsInFilter = $months;
        $usersInFilter = [];
        $productsInFilter = [];
        foreach ($reports as &$report) {
            $report['items'] = unserialize($report['items']);
            //$monthsInFilter[$report['month']] = $report['month'];
            $productsInFilter[$report['product']['name']] = $report['product']['name'];
            $usersInFilter[$report['user']['name']] = $report['user']['name'];
        }

        return compact('reports', 'months', 'monthsInFilter', 'usersInFilter', 'productsInFilter');
    }

    protected function getListByRange($from, $to)
    {
        $loggedUser = auth()->user();
        $reports = $this->reportService->getListByRange($from, $to, $loggedUser);
        $months = $this->reportService->getMonths();

        $monthsInFilter = $months;
        $usersInFilter = [];
        $productsInFilter = [];
        foreach ($reports as &$report) {
            $report['items'] = unserialize($report['items']);
            //$monthsInFilter[$report['month']] = $report['month'];
            $productsInFilter[$report['product']['name']] = $report['product']['name'];
            $usersInFilter[$report['user']['name']] = $report['user']['name'];
        }

        return compact('reports', 'months', 'monthsInFilter', 'usersInFilter', 'productsInFilter');
    }
}
