<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ActRequest;
use App\Services\ActService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class ActController extends Controller
{
    /**
     * @var ActService
     */
    private $actService;

    /**
     * SampleController constructor.
     *
     * @param ActService $actService
     */
    public function __construct(ActService $actService)
    {
        $this->actService = $actService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $userId = Auth::id();
        $acts = $this->actService->getAllAct($userId);

        return view('admin.act.index', compact('acts', 'userId'));
    }

    /**
     * @param ActRequest $request
     * @return Factory|View
     */
    public function addAct(ActRequest $request)
    {
        $attributes = $request->all();

        try {
            $act = $this->actService->create($attributes);
        } catch (\Exception $e) {
            echo $e->getMessage();;die;
            return response()->json(['message' => trans('messages.admin.errors.create', [], 'vi')], 202);
        }

        if ($act->id) {
            $response = [
                'user_id' => $act->user_id,
                'act_name' => $act->act_name,
                'act_id' => $act->act_id,
                'token' => $act->token,
                'cookie' => $act->cookie,
            ];

            return response()->json(
                ['act' => $response, 'message' => trans('messages.admin.success.create', [], 'vi')],
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
        $actData = json_decode(Redis::get('act_all_data_' . $userId));

        return view('admin.act.ad_account', compact('actData'));
    }

    public function reloadAccount()
    {
        $userId = Auth::id();
        /**
         * @var ActService $actService
         */
        $actService = app(ActService::class);
        $actData = $actService->getAllActInformation($userId);
        Redis::set('act_all_data_' . $userId, json_encode($actData));

        return response()->json(
            ['actData' => $actData, 'message' => trans('messages.admin.success.create', [], 'vi')],
            200
        );
    }
}
