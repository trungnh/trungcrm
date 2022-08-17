<?php

namespace App\Services;

use App\Repositories\ActRepository;
use App\Utilities\Facebook;
use Illuminate\Support\Facades\Http;

class ActService extends Service
{
    /**
     * @var ActRepository Repository
     */
    protected $actRepository;

    /**
     * QueryService constructor.
     *
     * @param $actRepository $actRepository
     */
    public function __construct(
        ActRepository $actRepository
    ){
        $this->actRepository = $actRepository;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getAllActInformation($userId)
    {
        $actData = [];
        $acts = $this->getAllAct($userId);
        foreach ($acts as $act) {
            $actData[$act->act_id]['act_name'] = $act->act_name;
            $actData[$act->act_id]['act_id'] = $act->act_id;
            $actData[$act->act_id]['payment'] = $this->getAdAccountPaymentInformationByActId($act->act_id, $act->token, $act->cookie);
        }

        return $actData;
    }

    /**
     * Get ada account info
     *
     * @param $actId
     * @param $token
     * @param $cookie
     * @return array
     */
    public function getAdAccountPaymentInformationByActId($actId, $token, $cookie)
    {
        $adAccountPaymentUrl = Facebook::getActAdAccountPaymentUrl($actId, $token);

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
            $threshold = $this->getAdAccountThreshold($actId, $token, $responseBody->currency, $cookie);
        }

        return Facebook::Payment($currentBilling, $minBilling, $maxBilling, $threshold);
    }

    /**
     * Get account threshold
     *
     * @param $actId
     * @param $token
     * @param $currency
     * @param $cookie
     * @return int
     */
    public function getAdAccountThreshold($actId, $token, $currency, $cookie)
    {
        $adAccountThresholdUrl = Facebook::getActAdAccountThresholdUrl($actId, $token);
        $response = $this->getRequest($adAccountThresholdUrl, $cookie);
        $responseBody = json_decode($response);
        if (!property_exists($responseBody, 'error') && property_exists($responseBody, 'adspaymentcycle')) {
            $adspaymentcycle = $responseBody->adspaymentcycle;
            if (property_exists($adspaymentcycle, 'data')) {
                $data = $adspaymentcycle->data;
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
        return $this->actRepository->create($attributes);
    }

    /**
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList($userId)
    {
        return $this->actRepository->getList($userId);
    }

    /**
     * @param $userId
     * @return \App\Models\Model[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllAct($userId)
    {
        return $this->actRepository->getAllAct($userId);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->actRepository->getById($id);
    }

    /**
     * @param string $actId
     * @return mixed
     */
    public function getByActId($actId)
    {
        return $this->actRepository->getByActId($actId);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function deleteById(int $id)
    {
        return $this->actRepository->deleteById($id);
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
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                'cookie: ' . $cookie,
                'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                //'accept-encoding: gzip, deflate, br',
                'accept-language: en-US,en;q=0.9',
                'cache-control: max-age=0',
                'connection: keep-alive',
                'upgrade-insecure-requests: 1'
            ]
        );
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        //curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, br');

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}
