<?php

namespace App\Services;

use App\Repositories\SampleRepository;

class SampleService extends Service
{
    /**
     * @var SampleRepository
     */
    protected $sampleRepository;

    /**
     * QueryService constructor.
     *
     * @param SampleRepository $sampleRepository
     */
    public function __construct(
        SampleRepository $sampleRepository
    ){
        $this->sampleRepository = $sampleRepository;
    }

    /**
     * @return string
     */
    public function getSampleText()
    {
        return 'Example';
    }
}
