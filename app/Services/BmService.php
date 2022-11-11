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
     * @param $via
     * @return array
     */
    public function getBmInformation($via)
    {
        $bmData = [];
        $bms = $this->getAllBms($via);
        foreach ($bms as $bm) {
            $bmData[$bm->id]['business_name'] = $bm->name;
            $bmData[$bm->id]['business_id'] = $bm->id;
            $bmData[$bm->id]['ad_account'] = $this->getBMAdAccount($bm, $via);
        }

        return $bmData;
    }

    /**
     * Get BM's account information
     *
     * @param $bm
     * @param $via
     * @return array
     */
    public function getBMAdAccount($bm, $via)
    {
        $adAccounts = [];

        // Get owned ad account
        $ownedAdAccountUrl = Facebook::getBMOwnedAccountUrl($bm->id, $via->token);
        $response = $this->getRequest($ownedAdAccountUrl, $via->proxy, $via->pass_proxy, $via->agent, $via->cookie);
        if (property_exists($response, 'data')) {
            foreach ($response->data as $item) {
                $adAccountPaymentInfo = $this->getAdAccountPaymentInformation($item->id, $bm->id, $via, $item->currency, $via->cookie);
                $adAccounts[] = Facebook::dataToAdAcount($item, $bm, $adAccountPaymentInfo);
            }
        }

        // Get client ad account
        $clientAdAccountUrl = Facebook::getBMClientAccountUrl($bm->id, $via->token);
        $response2 = $this->getRequest($clientAdAccountUrl, $via->proxy, $via->pass_proxy, $via->agent, $via->cookie);
        if (property_exists($response2, 'data')) {
            foreach ($response2->data as $item2) {
                $adAccountPaymentInfo = $this->getAdAccountPaymentInformation($item2->id, $bm->id, $via, $item2->currency, $via->cookie);
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
     * @param $via
     * @param $currency
     * @return \stdClass
     */
    public function getAdAccountPaymentInformation($actId, $bmId, $via, $currency)
    {
        $adAccountPaymentUrl = Facebook::getAdAccountPaymentUrl($actId, $bmId, $via->token);
        $response = $this->getRequest($adAccountPaymentUrl, $via->proxy, $via->pass_proxy, $via->agent, $via->cookie);
        $currentBilling = 0;
        $minBilling = 0;
        $maxBilling = 0;
        $threshold = 0;
        $nextDayBilling = 0;
        if (!property_exists($response, 'error')) {
            $currentBilling = str_replace('.', '', $response->current_unbilled_spend->amount);
            $minBilling = str_replace('.', '', $response->min_billing_threshold->amount);
            $maxBilling = str_replace('.', '', $response->max_billing_threshold->amount);
            $threshold = $this->getAdAccountThreshold($actId, $bmId, $via, $currency, $via->cookie);
            $nextDayBilling = date('Y-m-d', strtotime($response->next_bill_date));
        }

        return Facebook::Payment($currentBilling, $minBilling, $maxBilling, $threshold, $nextDayBilling);
    }

    /**
     * Get account threshold
     *
     * @param $actId
     * @param $bmId
     * @param $via
     * @param $currency
     * @return int
     */
    public function getAdAccountThreshold($actId, $bmId, $via, $currency)
    {
        $adAccountLimitUrl = Facebook::getAdAccountLimitUrl($actId, $bmId, $via->token);
        $response = $this->getRequest($adAccountLimitUrl, $via->proxy, $via->pass_proxy, $via->agent, $via->cookie);
        if (!property_exists($response, 'error') && property_exists($response, 'data')) {
            $data = $response->data;
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
     * @param $via
     * @param $timeRange
     * @return mixed
     */
    public function getListCampInformation($actId, $via, $timeRange)
    {
        $listCampUrl = Facebook::getListCampUrl($actId, $via->token, $timeRange);
        $response = $this->getRequest($listCampUrl, $via->proxy, $via->pass_proxy, $via->agent, $via->cookie);
        if (!property_exists($response, 'error') && property_exists($response, 'data')) {
            return $response->data;
        }
    }

    /**
     * @param $via
     * @return array
     */
    public function getAllBms($via)
    {
        // Get uid
        $listBMUrl = Facebook::getBMUrl($via->uid, $via->token);
        $response = $this->getRequest($listBMUrl, $via->proxy, $via->pass_proxy, $via->agent, $via->cookie);
        if (!property_exists($response, 'error') && property_exists($response, 'data')) {
            return $response->data;
        }

        return [];
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
     * @param $proxy
     * @param $proxyauth
     * @param $agent
     * @param $cookie
     * @return mixed
     */
	public function getRequest($url, $proxy, $proxyauth, $agent, $cookie)
	{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'cookie: '.$cookie,
            'user-agent: '.$agent,
            'sec-fetch-site: same-site',
        ));

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_PROXY, $proxy);     // PROXY details with port
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);   // Use if proxy have username and password
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); // If expected to call with specific PROXY type
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $data = json_decode($response);

        curl_close($ch);

		return $data;
	}

    /**
     * @param $url
     * @param $postData
     * @param $proxy
     * @param $proxyauth
     * @param $agent
     * @param $cookie
     * @return mixed
     */
    public function postRequest($url, $postData, $proxy, $proxyauth, $agent, $cookie)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'cookie: '.$cookie,
            'user-agent: '.$agent,
            'sec-fetch-site: same-site',
        ));

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_PROXY, $proxy);     // PROXY details with port
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);   // Use if proxy have username and password
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); // If expected to call with specific PROXY type
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $data = json_decode($response);

        curl_close($ch);

        return $data;
    }
}
