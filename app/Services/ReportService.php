<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService extends Service
{
    /**
     * @var ReportRepository
     */
    protected $reportRepository;

    /**
     * QueryService constructor.
     *
     * @param ReportRepository $reportRepository
     */
    public function __construct(
        ReportRepository $reportRepository
    ){
        $this->reportRepository = $reportRepository;
    }

    public function getMonths()
    {
        $prevY = date('Y', strtotime('-1 year'));
        $currentY = date('Y');
        $months = [];

        foreach(['10', '11', '12'] as $m) {
            $months[] = $prevY . '-' . $m;
        }

        for ($i=1; $i<=12; $i++) {
            $months[] = $currentY . '-' . $i;
        }

        return $months;
    }

    public function getById($id)
    {
        $report = $this->reportRepository->find($id);
        $report->items = unserialize($report->items);

        return $report;
    }

    public function create($attributes)
    {
        return $this->reportRepository->create($attributes);
    }

    public function getList($loggedUser)
    {
        return $this->reportRepository->getList($loggedUser);
    }

    public function getListByMonth($month, $loggedUser, $userId = null, $productId = null)
    {
        return $this->reportRepository->getListByMonth($month, $loggedUser, $userId, $productId);
    }

    public function getListByRange($from, $to, $loggedUser)
    {
        return $this->reportRepository->getListByRange($from, $to, $loggedUser);
    }

    public function getAllReports()
    {
        return $this->reportRepository->getAllReports();
    }
}
