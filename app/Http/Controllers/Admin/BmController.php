<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BmRequest;
use App\Services\BmService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use App\Utilities\Facebook;
use Illuminate\Support\Facades\Redis;

class BmController extends Controller
{
    /**
     * @var BmService
     */
    private $bmService;

    /**
     * SampleController constructor.
     *
     * @param BmService $bmService
     */
    public function __construct(BmService $bmService)
    {
        $this->bmService = $bmService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $bms = $this->bmService->getList();

        return view('admin.bm.index', compact('bms'));
    }

    /**
     * @param BmRequest $request
     * @return Factory|View
     */
    public function addBm(BmRequest $request)
    {
        $attributes = $request->all();

        try {
            $bm = $this->bmService->create($attributes);
        } catch (\Exception $e) {
            echo $e->getMessage();die;
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
        }

        if ($bm->id) {
            $response = [
                'business_name' => $bm->business_name,
                'business_id' => $bm->business_id,
                'token' => $bm->token,
            ];

            return response()->json(
                ['product' => $response, 'message' => trans('messages.admin.success.create', [], 'vi')],
                200
            );
        }

        return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View
     */
    public function adAccount()
    {
        $bmData = json_decode(Redis::get('bm_all_data'));

        return view('admin.bm.ad_account', compact('bmData'));
    }

    public function reloadAccount()
    {
        /**
         * @var BmService $bmService
         */
        $bmService = app(BmService::class);
        $bmData = $bmService->getBmInformation();

        Redis::set('bm_all_data', json_encode($bmData));

        return response()->json(
            ['bmData' => $bmData, 'message' => trans('messages.admin.success.create', [], 'vi')],
            200
        );
    }
}
