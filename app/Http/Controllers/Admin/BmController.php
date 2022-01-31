<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BmRequest;
use App\Http\Requests\Request;
use App\Services\BmService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
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
        $userId = Auth::id();
        $bms = $this->bmService->getAllBms($userId);

        return view('admin.bm.index', compact('bms', 'userId'));
    }

    /**
     * @param BmRequest $request
     * @param int $id
     * @return Factory|View
     */
    public function edit(BmRequest $request, int $id)
    {
        $userId = Auth::id();
        $bm = $this->bmService->getById($id);

        return view('admin.bm.edit', compact('bm', 'userId'));
    }

    /**
     * @param BmRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveBm(BmRequest $request)
    {
        $attributes = $request->all();
        $bm = $this->bmService->getById($attributes['id']);
        if ($bm) {
            $bm->update($attributes);
        }

        return response()->json(['message' => trans('messages.admin.success.create', [], 'vi')], 200);
    }

    /**
     * @param BmRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removeBm(BmRequest $request)
    {
        $attributes = $request->all();
        $this->bmService->deleteById($attributes['id']);

        return response()->json(['message' => trans('messages.admin.success.create', [], 'vi')], 200);
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
            dd($e->getMessage());
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
        }

        if ($bm->id) {
            $response = [
                'user_id' => $bm->user_id,
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
        $userId = Auth::id();
        $bmData = json_decode(Redis::get('bm_all_data_' . $userId));

        return view('admin.bm.ad_account', compact('bmData'));
    }

    public function reloadAccount()
    {
        $userId = Auth::id();
        /**
         * @var BmService $bmService
         */
        $bmService = app(BmService::class);
        $bmData = $bmService->getBmInformation($userId);

        Redis::set('bm_all_data_' . $userId, json_encode($bmData));

        return response()->json(
            ['bmData' => $bmData, 'message' => trans('messages.admin.success.create', [], 'vi')],
            200
        );
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View
     */
    public function camp()
    {
        $userId = Auth::id();
        $bmData = json_decode(Redis::get('bm_all_data_' . $userId));

        return view('admin.bm.camp', compact('bmData'));
    }

    public function getCampData(Request $request)
    {
        $params = $request->all();
        $timeRange = "time_range=%7B%22since%22%3A%22" . date('Y-m-d', strtotime($params['start'])) . "%22%2C%22until%22%3A%22" . date('Y-m-d', strtotime($params['end'])) . "%22%7D";
        /**
         * @var BmService $bmService
         */
        $bmService = app(BmService::class);
        // getBM by businessID
        $bm = $bmService->getByBusinessId($params['bm_id']);
        $data = $bmService->getListCampInformation('act_' . $params['ada_id'], $bm->token, $timeRange);

        return response()->json(
            ['campData' => $data, 'message' => trans('messages.admin.success.create', [], 'vi')],
            200
        );
    }

    public function test()
    {
        $userId = Auth::id();
        /**
         * @var BmService $bmService
         */
        $bmService = app(BmService::class);
        $bmData = $bmService->getBmInformation($userId);
        dd($bmData);
    }
}
