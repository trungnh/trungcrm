<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BmService;
use Illuminate\Support\Facades\Redis;
use App\Utilities\General;

class Facebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:getBm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl data from online re-source';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var BmService $bmService
         */
        $bmService = app(BmService::class);
        $bmData = $bmService->getBmInformation();

        Redis::set('bm_all_data', json_encode($bmData));
        $this->sendNotice($bmData);
    }

    /**
     * Check billing and threshold then send message to telegram
     *
     * @param $bmData
     * @return void
     */
    public function sendNotice($bmData)
    {
        foreach ($bmData as $bmID => $bm) {
            foreach ($bm['ad_account'] as $adAccount) {
                $currentBilling = intval($adAccount->payment->currentBilling);
                $threshold = $adAccount->payment->threshold;
                if ($currentBilling >= ($threshold * 0.85)) {
                    $currentBillingStr = number_format($currentBilling, 0, ',', '.');
                    $thresholdStr = number_format($threshold, 0, ',', '.');
                    $message = "Cần thanh toán: {$adAccount->business->businessName} - {$adAccount->name}: {$currentBillingStr}/{$thresholdStr}";
                    General::sendMessageToTelegramBot($message);
                }
            }
        }
    }
}
