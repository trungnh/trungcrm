<?php

namespace App\Console\Commands;

use App\Services\ActService;
use App\Services\UserService;
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
        $currentH = date('H');
        if ($currentH > 7) {
            // Get all user
            /**
             * @var UserService $userService
             */
            $userService = app(UserService::class);
            $users = $userService->getAllUser();
            foreach ($users as $user) {
                /**
                 * @var BmService $bmService
                 */
                $bmService = app(BmService::class);
                $bmData = $bmService->getBmInformation($user->id);

                Redis::set('bm_all_data_' . $user->id, json_encode($bmData));
                if (!empty($bmData)) {
                    $this->sendNotice($user->id, $bmData);
                }

                /**
                 * @var ActService $actService
                 */
                $actService = app(ActService::class);
                $actData = $actService->getAllActInformation($user->id);
                Redis::set('act_all_data_' . $user->id, json_encode($actData));
                if (!empty($actData)) {
                    $this->sendActNotice($user->id, $actData);
                }
            }
        }
    }

    /**
     * Check billing and threshold then send message to telegram
     *
     * @param $userId
     * @param $bmData
     * @return void
     */
    public function sendNotice($userId, $bmData)
    {
        /**
         * @var UserService $userService
         */
        $userService = app(UserService::class);
        $user = $userService->getById($userId);
        foreach ($bmData as $bmID => $bm) {
            $ignoredAdaIds = explode(',', $bm['ignored_ada_ids']);
            foreach ($bm['ad_account'] as $adAccount) {
                // Ignore sending notice
                if (in_array($adAccount->accountId, $ignoredAdaIds)) {
                    continue;
                }
                $currentBilling = intval($adAccount->payment->currentBilling);
                $threshold = $adAccount->payment->threshold;
                if ($currentBilling >= ($threshold * 0.85)) {
                    $currentBillingStr = number_format($currentBilling, 0, ',', '.');
                    $thresholdStr = number_format($threshold, 0, ',', '.');
                    $message = "Cần thanh toán: {$adAccount->business->businessName} - {$adAccount->name}: {$currentBillingStr}/{$thresholdStr}";
                    General::sendMessageToTelegramBot($user->chat_id, $message);
                }
            }
        }
    }

    /**
     * Check billing and threshold then send message to telegram
     *
     * @param $userId
     * @param $actData
     * @return void
     */
    public function sendActNotice($userId, $actData)
    {
        /**
         * @var UserService $userService
         */
        $userService = app(UserService::class);
        $user = $userService->getById($userId);
        foreach ($actData as $actId => $act) {
            $currentBilling = intval($act['payment']->currentBilling);
            $threshold = $act['payment']->threshold;
            if ($currentBilling >= ($threshold * 0.85)) {
                $currentBillingStr = number_format($currentBilling, 0, ',', '.');
                $thresholdStr = number_format($threshold, 0, ',', '.');
                $message = "Cần thanh toán: TK cá nhân - {$act['act_name']} - {$act['act_id']}: {$currentBillingStr}/{$thresholdStr}";
                General::sendMessageToTelegramBot($user->chat_id, $message);
            }
        }
    }
}
