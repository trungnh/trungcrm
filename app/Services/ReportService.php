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
        $currentY = date('Y');
        $months = [];
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

    public function getListByMonth($month, $loggedUser)
    {
        return $this->reportRepository->getListByMonth($month, $loggedUser);
    }

    public function getAllReports()
    {
        return $this->reportRepository->getAllReports();
    }
}
