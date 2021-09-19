<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\IndexRequest;
use App\Services\SampleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class SampleController extends Controller
{
    /**
     * @var SampleService
     */
    private $sampleService;

    /**
     * SampleController constructor.
     *
     * @param SampleService $sampleService
     */
    public function __construct(SampleService $sampleService)
    {
        $this->sampleService = $sampleService;
    }

    /**
     * @param IndexRequest $request
     * @return Factory|View
     */
    public function index(IndexRequest $request)
    {
        $content = $this->sampleService->getSampleText();

        return view('admin.sample.index', compact('content'));
    }
}
