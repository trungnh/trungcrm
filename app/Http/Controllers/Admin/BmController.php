<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BmRequest;
use App\Http\Requests\Request;
use App\Services\BmService;
use App\Services\TaiKhoanService;
use App\Services\UserService;
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
     * @var TaiKhoanService
     */
    private $taiKhoanService;

    /**
     * SampleController constructor.
     *
     * @param BmService $bmService
     */
    public function __construct(BmService $bmService, TaiKhoanService $taiKhoanService)
    {
        $this->bmService = $bmService;
        $this->taiKhoanService = $taiKhoanService;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $userId = Auth::id();

        $via = $this->taiKhoanService->getByUserId($userId);
        $bms = $this->bmService->getAllBms($via);

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
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View
     */
    public function adAccount()
    {
        $userId = Auth::id();
        $bmData = json_decode(Redis::get('bm_all_data_' . $userId));

        return view('admin.bm.ad_account', compact('bmData', 'userId'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAdaIgnoreIds(Request $request)
    {
        $ignoredAdaIds = $request->post('ignored_ada_ids');
        $userId = Auth::id();
        /**
         * @var UserService $userService
         */
        $userService = app(UserService::class);
        $user = $userService->getById($userId);
        $user->ada_ignore_ids = $ignoredAdaIds;
        $user->save();

        return response()->json(
            ['data' => [], 'message' => trans('messages.admin.success.create', [], 'vi')],
            200
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reloadAccount()
    {
        $userId = Auth::id();
        /**
         * @var BmService $bmService
         */
        $bmService = app(BmService::class);
        /**
         * @var TaiKhoanService $taiKhoanService
         */
        $taiKhoanService = app(TaiKhoanService::class);

        $via = $taiKhoanService->getByUserId($userId);
        $bmData = $bmService->getBmInformation($via);

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
