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
        $response = $this->getRequest($ownedAdAccountUrl, $bm->cookie);
        $responseBody = json_decode($response);
        if (property_exists($responseBody, 'data')) {
            foreach ($responseBody->data as $item) {
                $adAccountPaymentInfo = $this->getAdAccountPaymentInformation($item->id, $bm->business_id, $bm->token, $item->currency, $bm->cookie);
                $adAccounts[] = Facebook::dataToAdAcount($item, $bm, $adAccountPaymentInfo);
            }
        }

        // Get client ad account
        $clientAdAccountUrl = Facebook::getBMClientAccountUrl($bm->business_id, $bm->token);
        $response2 = $this->getRequest($clientAdAccountUrl, $bm->cookie);
        $responseBody2 = json_decode($response2);
        if (property_exists($responseBody2, 'data')) {
            foreach ($responseBody2->data as $item2) {
                $adAccountPaymentInfo = $this->getAdAccountPaymentInformation($item2->id, $bm->business_id, $bm->token, $item2->currency, $bm->cookie);
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
     * @param $cookie
     * @return \stdClass
     */
    public function getAdAccountPaymentInformation($actId, $bmId, $bmToken, $currency, $cookie = '')
    {
        $adAccountPaymentUrl = Facebook::getAdAccountPaymentUrl($actId, $bmId, $bmToken);
        $response = $this->getRequest($adAccountPaymentUrl, $cookie);
        $responseBody = json_decode($response);
        $currentBilling = 0;
        $minBilling = 0;
        $maxBilling = 0;
        $threshold = 0;
        if (!property_exists($responseBody, 'error')) {
            $currentBilling = str_replace('.', '', $responseBody->current_unbilled_spend->amount);
            $minBilling = str_replace('.', '', $responseBody->min_billing_threshold->amount);
            $maxBilling = str_replace('.', '', $responseBody->max_billing_threshold->amount);
            $threshold = $this->getAdAccountThreshold($actId, $bmId, $bmToken, $currency, $cookie);
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
     * @param $cookie
     * @return int
     */
    public function getAdAccountThreshold($actId, $bmId, $bmToken, $currency, $cookie = '')
    {
        $adAccountLimitUrl = Facebook::getAdAccountLimitUrl($actId, $bmId, $bmToken);
        $response = $this->getRequest($adAccountLimitUrl, $cookie);
        $responseBody = json_decode($response);
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
     * Get list campaign information
     *
     * @param $actId
     * @param $bmId
     * @param $bmToken
     * @param $timeRange
     * @param $cookie
     * @return mixed
     */
    public function getListCampInformation($actId, $bmToken, $timeRange, $cookie = '')
    {
        $listCampUrl = Facebook::getListCampUrl($actId, $bmToken, $timeRange);
        $response = $this->getRequest($listCampUrl, $cookie);
        $responseBody = json_decode($response);
        if (!property_exists($responseBody, 'error') && property_exists($responseBody, 'data')) {
            return $responseBody->data;
        }
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
     * @param string $bmId
     * @return mixed
     */
    public function getByBusinessId($bmId)
    {
        return $this->bmRepository->getByBusinessId($bmId);
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
	
	/**
     * @param $url
     * @param $cookie
	 *
     * @return mixed
     */
	public function getRequest($url, $cookie)
	{
		$ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'cookie: ' . $cookie)
			);

        $output = curl_exec($ch);
        curl_close($ch);    

		return $output;		
	}
}
