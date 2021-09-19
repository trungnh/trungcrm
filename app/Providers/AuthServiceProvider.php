<?php

namespace App\Providers;

use App\Endpoints\Endpoint;
use App\System\Auth\EndpointProvider\Contracts\AuthEndpoint;
use App\System\Auth\EndpointProvider\EndpointUserProvider;
use App\System\Auth\StaticProvider\Contracts\FileAuthParser;
use App\System\Auth\StaticProvider\StaticUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
