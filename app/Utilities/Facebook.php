<?php
namespace App\Utilities;

use App\Models\Bm;
use Illuminate\Support\Facades\Http;

class Facebook
{
    const FB_API_ENDPOINT = 'https://graph.facebook.com';
    const FB_API_VERSION = 'v11.0';
    const SESSION_ID = '2b24b38c0e92085c';
    const BM_OWNED_AD_ACCOUNT_PATH = '/owned_ad_accounts?access_token=';
    const BM_OWNED_AD_ACCOUNT_FIELDS = '&fields=%5B%22id%22%2C%22name%22%2C%22account_id%22%2C%22account_status%22%2C%22disable_reason%22%2C%22business%22%2C%22currency%22%2C%22timezone_name%22%2C%22end_advertiser%22%2C%22end_advertiser_name%22%2C%22invoicing_emails%22%2C%22funding_source%22%2C%22onbehalf_requests.fields(receiving_business.fields(name)%2Cstatus)%22%5D&sort=name_ascending&suppress_http_code=1';
    const BM_CLIENT_AD_ACCOUNT_PATH = '/client_ad_accounts?access_token=';
    const BM_CLIENT_AD_ACCOUNT_FIELDS = '&fields=%5B%22id%22%2C%22name%22%2C%22account_id%22%2C%22account_status%22%2C%22disable_reason%22%2C%22business%22%2C%22currency%22%2C%22timezone_name%22%2C%22end_advertiser%22%2C%22end_advertiser_name%22%2C%22invoicing_emails%22%2C%22funding_source%22%2C%22onbehalf_requests.fields(receiving_business.fields(name)%2Cstatus)%22%5D&sort=name_ascending&suppress_http_code=1';

    const AD_PAYMENT_PATH_1 = '?_reqName=adaccount&access_token=';
    const AD_PAYMENT_PATH_2 = '&__business_id=';
    const AD_PAYMENT_PATH_3 = '&_reqName=adaccount&_reqSrc=AdsCMPaymentsAccountDataDispatcher&_sessionID=';
    const AD_PAYMENT_PATH_4 = '&fields=';
    const AD_PAYMENT_FIELDS = '%5B%22active_billing_date_preference%7Bday_of_month%2Cid%2Cnext_bill_date%2Ctime_created%2Ctime_effective%7D%22%2C%22can_pay_now%22%2C%22can_repay_now%22%2C%22current_unbilled_spend%22%2C%22extended_credit_info%22%2C%22is_br_entity_account%22%2C%22has_extended_credit%22%2C%22max_billing_threshold%22%2C%22min_billing_threshold%22%2C%22min_payment%22%2C%22next_bill_date%22%2C%22pending_billing_date_preference%7Bday_of_month%2Cid%2Cnext_bill_date%2Ctime_created%2Ctime_effective%7D%22%2C%22promotion_progress_bar_info%22%2C%22show_improved_boleto%22%2C%22business%7Bid%2Cname%2Cpayment_account_id%7D%22%2C%22total_prepay_balance%22%2C%22is_in_3ds_authorization_enabled_market%22%2C%22current_unpaid_unrepaid_invoice%22%2C%22has_repay_processing_invoices%22%5D&include_headers=false&locale=vi_VN&method=get&pretty=0&suppress_http_code=1';

    const AD_LIMIT_PATH_1 = '/adspaymentcycle?_reqName=adaccount%2Fadspaymentcycle&access_token=';
    const AD_LIMIT_PATH_2 = '&__business_id=';
    const AD_LIMIT_PATH_3 = '&_reqName=adaccount%2Fadspaymentcycle&_reqSrc=AdsCMBillingTransactionsDataLoader&_sessionID=';
    const AD_LIMIT_PATH_4 = '&include_headers=false&locale=vi_VN&method=get&pretty=0&suppress_http_code=1';



    public static function getBMOwnedAccountUrl($bmId, $token)
    {
        return self::FB_API_ENDPOINT . '/' .
            self::FB_API_VERSION . '/' .
            $bmId .
            self::BM_OWNED_AD_ACCOUNT_PATH .
            $token .
            self::BM_OWNED_AD_ACCOUNT_FIELDS;
    }

    public static function getBMClientAccountUrl($bmId, $token)
    {
        return self::FB_API_ENDPOINT . '/' .
            self::FB_API_VERSION . '/' .
            $bmId .
            self::BM_CLIENT_AD_ACCOUNT_PATH .
            $token .
            self::BM_CLIENT_AD_ACCOUNT_FIELDS;
    }

    public static function getAdAccountPaymentUrl($actId, $bmId, $token)
    {
        return self::FB_API_ENDPOINT . '/' .
            self::FB_API_VERSION . '/' .
            $actId .
            self::AD_PAYMENT_PATH_1 .
            $token .
            self::AD_PAYMENT_PATH_2 .
            $bmId .
            self::AD_PAYMENT_PATH_3 .
            self::SESSION_ID .
            self::AD_PAYMENT_PATH_4 .
            self::AD_PAYMENT_FIELDS;
    }

    public static function getAdAccountLimitUrl($actId, $bmId, $token) {

        return self::FB_API_ENDPOINT . '/' .
            self::FB_API_VERSION . '/' .
            $actId .
            self::AD_LIMIT_PATH_1 .
            $token .
            self::AD_LIMIT_PATH_2 .
            $bmId .
            self::AD_LIMIT_PATH_3 .
            self::SESSION_ID .
            self::AD_LIMIT_PATH_4;
    }

    public static function dataToAdAcount($data, $bm, $adAccountPaymentInfo)
    {
        $isDisabled = $data->account_status == 2 ? true : false;
        $actId = $data->id;
        $name = $data->name;
        $accountId = $data->account_id;
        $status = $data->account_status;
        $business = new \stdClass();
        if (property_exists($data, 'business')) {
            $business->businessId = $data->business->id;
            $business->businessName = $data->business->name;
        } else {
            $business->businessId = $bm->business_id;
            $business->businessName = $bm->business_name;
        }

        $currency = $data->currency;
        $timezone = $data->timezone_name;
        $payment = $adAccountPaymentInfo;

        return self::AdAccount($actId, $name, $accountId, $status, $business, $currency, $timezone, $isDisabled, $payment);
    }

    public static function AdAccount($actId, $name, $accountId, $status, $business, $currency, $timezone, $isDisabled, $payment)
    {
        $adAccount = new \stdClass();
        $adAccount->actId = $actId;
        $adAccount->name = $name;
        $adAccount->accountId = $accountId;
        $adAccount->status = $status;
        $adAccount->business = $business;
        $adAccount->currency = $currency;
        $adAccount->timezone = $timezone;
        $adAccount->isDisabled = $isDisabled;
        $adAccount->payment = $payment;

        return $adAccount;
    }

    public static function Payment($currentBilling, $minBilling, $maxBilling, $threshold)
    {
        $payment = new \stdClass();
        $payment->currentBilling = $currentBilling;
        $payment->minBilling = $minBilling;
        $payment->maxBilling = $maxBilling;
        $payment->threshold = $threshold;

        return $payment;
    }
}
