<?php

namespace App\Http\View\Composers;

use App\Services\SampleService;
use Illuminate\View\View;

class SampleComposer
{
    /**
     * The user repository implementation.
     *
     * @var SampleService
     */
    protected $sampleService;

    /**
     * Create a new profile composer.
     *
     * @param SampleService $sampleService
     * @return void
     */
    public function __construct(SampleService $sampleService)
    {
        // Dependencies automatically resolved by service container...
        $this->sampleService = $sampleService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sample_text', $this->sampleService->getSampleText());
    }
}