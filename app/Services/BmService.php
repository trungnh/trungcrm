<?php

namespace App\Services;

use App\Repositories\BmRepository;
use App\Utilities\Facebook;
use Illuminate\Support\Facades\Http;

class BmService extends Service
{
    /**
     * @var BmRepository
     */
    protected $bmRepository;

    /**
     * QueryService constructor.
     *
     * @param $bmRepository $bmRepository
     */
    public function __construct(
        BmRepository $bmRepository
    ){
        $this->bmRepository = $bmRepository;
    }

    /**
     * @return array
     */
    public function getBmInformation($id)
    {
        $bmData = [];
        $bms = $this->getAllBms($id);
        foreach ($bms as $bm) {
            $bmData[$bm->business_id]['business_name'] = $bm->business_name;
            $bmData[$bm->business_id]['business_id'] = $bm->business_id;
            $bmData[$bm->business_id]['ignored_ada_ids'] = $bm->ignored_ada_ids;
            $bmData[$bm->business_id]['ad_account'] = $this->getBMAdAccount($bm);
        }

        return $bmData;
    }

    /**
     * Get BM's account infor
     *
     * @param $bm
     * @return array
     */
    public function getBMAdAccount($bm)
    {
        $adAccounts = [];

        // Get owned ad account
        $ownedAdAccountUrl = Facebook::getBMOwnedAccountUrl($bm->business_id, $bm->token);
        $response = Http::get($ownedAdAccountUrl);
        $responseBody = json_decode($response->body());
        if (property_exists($responseBody, 'data')) {
            foreach ($responseBody->data as $item) {
                $adAccountPaymentInfo = $this->getAdAccountPaymentInformation($item->id, $bm->business_id, $bm->token, $item->currency);
                $adAccounts[] = Facebook::dataToAdAcount($item, $bm, $adAccountPaymentInfo);
            }
        }

        // Get client ad account
        $clientAdAccountUrl = Facebook::getBMClientAccountUrl($bm->business_id, $bm->token);
        $response2 = Http::get($clientAdAccountUrl);
        $responseBody2 = json_decode($response2->body());
        if (property_exists($responseBody2, 'data')) {
            foreach ($responseBody2->data as $item2) {
                $adAccountPaymentInfo = $this->getAdAccountPaymentInformation($item2->id, $bm->business_id, $bm->token, $item2->currency);
                $adAccounts[] = Facebook::dataToAdAcount($item2, $bm, $adAccountPaymentInfo);
            }
        }

        return $adAccounts;
    }

    /**
     * Get ad account payment info
     *
     * @param $actId
     * @param $bmId
     * @param $bmToken
     * @param $currency
     * @return \stdClass
     */
    public function getAdAccountPaymentInformation($actId, $bmId, $bmToken, $currency)
    {
        $adAccountPaymentUrl = Facebook::getAdAccountPaymentUrl($actId, $bmId, $bmToken);
        $response = Http::get($adAccountPaymentUrl);
        $responseBody = json_decode($response->body());
        $currentBilling = 0;
        $minBilling = 0;
        $maxBilling = 0;
        $threshold = 0;
        if (!property_exists($responseBody, 'error')) {
            $currentBilling = str_replace('.', '', $responseBody->current_unbilled_spend->amount);
            $minBilling = str_replace('.', '', $responseBody->min_billing_threshold->amount);
            $maxBilling = str_replace('.', '', $responseBody->max_billing_threshold->amount);
            $threshold = $this->getAdAccountThreshold($actId, $bmId, $bmToken, $currency);
        }

        return Facebook::Payment($currentBilling, $minBilling, $maxBilling, $threshold);
    }

    /**
     * Get account threshold
     *
     * @param $actId
     * @param $bmId
     * @param $bmToken
     * @param $currency
     * @return int
     */
    public function getAdAccountThreshold($actId, $bmId, $bmToken, $currency)
    {
        $adAccountLimitUrl = Facebook::getAdAccountLimitUrl($actId, $bmId, $bmToken);
        $response = Http::get($adAccountLimitUrl);
        $responseBody = json_decode($response->body());
        if (!property_exists($responseBody, 'error') && property_exists($responseBody, 'data')) {
            $data = $responseBody->data;
            if (empty($data)) {
                return 0;
            }
            $thresholdStr = '';
            if (property_exists($data[0], 'threshold_amount')) {
                $thresholdStr = $data[0]->threshold_amount;
            }

            if (strtolower($currency) != 'vnd') {
                $threshold = substr($thresholdStr, 0, -2);

                return intval($threshold);
            } else {
                return intval($thresholdStr);
            }
        }

        return 0;
    }

    /**
     * @param $attributes
     * @return mixed
     * @throws \Exception
     */
    public function create($attributes)
    {
        return $this->bmRepository->create($attributes);
    }

    /**
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList($userId)
    {
        return $this->bmRepository->getList($userId);
    }

    /**
     * @param $userId
     * @return \App\Models\Model[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllBms($userId)
    {
        return $this->bmRepository->getAllBms($userId);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->bmRepository->getById($id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function deleteById(int $id)
    {
        return $this->bmRepository->deleteById($id);
    }
}
