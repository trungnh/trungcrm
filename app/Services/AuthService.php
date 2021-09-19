<?php

namespace App\Services;

use App\Endpoints\Endpoint;

class AuthService extends Service
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * AuthService constructor.
     *
     * @param Endpoint $endpoint
     */
    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }
}
