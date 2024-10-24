<?php

namespace App\Http\Controllers\Admin;

use App\Services\ReportService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @var ReportService
     */
    private $reportService;

    /**
     * Create a new controller instance.
     *
     * @param ReportService $reportService
     *
     * @return void
     */
    public function __construct(ReportService $reportService)
    {
        $this->middleware('auth');
        $this->reportService = $reportService;
    }

    /**
     * Show home page.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $loggedUser = auth()->user();
        $monthsInFilter = $this->reportService->getMonths();

        $lastMonth = date('Y-n', strtotime('first day of last month'));
        $thisMonth = date('Y-n');
        $reportsOfLastMonth = $this->reportService->getListByMonth($lastMonth, $loggedUser);
        foreach ($reportsOfLastMonth as &$report) {
            $report['items'] = unserialize($report['items']);
        }

        $thisMonthReportItemsTable = [];
        $reportsOfThisMonth = $this->reportService->getListByMonth($thisMonth, $loggedUser);
        foreach ($reportsOfThisMonth as &$report1) {
            $report1['items'] = unserialize($report1['items']);
        }

        return view('admin.home.index', compact('reportsOfLastMonth', 'reportsOfThisMonth', 'thisMonthReportItemsTable', 'monthsInFilter', 'loggedUser'));
    }

    /**
     * changeReportMonth
     *
     * @param Request $request
     * @param string $month
     *
     * @return Factory|View
     */
    public function changeReportMonth(Request $request, $month)
    {
        $loggedUser = auth()->user();
        $fullThisMonth = date('Y-m-d', strtotime(date($month . '-1')));
        $lastMonth = date('Y-n', strtotime($fullThisMonth . ' -1 MONTH'));
        $thisMonth = date('Y-n',  strtotime($fullThisMonth));

        $reportsOfLastMonth = $this->reportService->getListByMonth($lastMonth, $loggedUser);
        foreach ($reportsOfLastMonth as &$report) {
            $report['items'] = unserialize($report['items']);
        }

        $thisMonthReportItemsTable = [];
        $reportsOfThisMonth = $this->reportService->getListByMonth($thisMonth, $loggedUser);
        foreach ($reportsOfThisMonth as &$report1) {
            $reportItemTmp = unserialize($report1['items']);
            $report1['items'] = $reportItemTmp;

            foreach($reportItemTmp as $item) {
                if (!isset($thisMonthReportItemsTable[$item['date']])) {
                    $thisMonthReportItemsTable[$item['date']] = [
                        "date" => $item['date'],
                        "orders" => $item['orders'],
                        "product_qty" => $item['product_qty'],
                        "ads_amount" => $item['ads_amount'],
                        "revenue" => $item['revenue'],
                        "totalUnitPrice" => $item['totalUnitPrice'],
                        "totalShippingPrice" => $item['totalShippingPrice'],
                        "totalReturnPrice" => $item['totalReturnPrice'],
                        "totalSpent" => $item['totalSpent'],
                        "profit" => $item['profit']
                    ];
                } else {
                    if ($thisMonthReportItemsTable[$item['date']]['date'] ==  $item['date']) {
                        $thisMonthReportItemsTable[$item['date']]['orders'] += $item['orders'];
                        $thisMonthReportItemsTable[$item['date']]['product_qty'] += $item['product_qty'];
                        $thisMonthReportItemsTable[$item['date']]['ads_amount'] += $item['ads_amount'];
                        $thisMonthReportItemsTable[$item['date']]['revenue'] += $item['revenue'];
                        $thisMonthReportItemsTable[$item['date']]['totalUnitPrice'] += $item['totalUnitPrice'];
                        $thisMonthReportItemsTable[$item['date']]['totalShippingPrice'] += $item['totalShippingPrice'];
                        $thisMonthReportItemsTable[$item['date']]['totalReturnPrice'] += $item['totalReturnPrice'];
                        $thisMonthReportItemsTable[$item['date']]['totalSpent'] += $item['totalSpent'];
                        $thisMonthReportItemsTable[$item['date']]['profit'] += $item['profit'];
                    }
                }
            }
        }

        return response()->json(
            ['reportsOfThisMonth' => $reportsOfThisMonth, 'reportsOfLastMonth' => $reportsOfLastMonth, 'thisMonthReportItemsTable' => $thisMonthReportItemsTable],
            200
        );
    }
}
