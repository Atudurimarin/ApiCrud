<?php

namespace App\Providers;

use ReflectionException;
use App\JsonApi\JsonApiQueryBuilder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\JsonApi\JsonApiTestResponse;
use Illuminate\Testing\TestResponse;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @throws ReflectionException
     */
    public function boot()
    {
        TestResponse::mixin(new JsonApiTestResponse());

        Builder::mixin(new JsonApiQueryBuilder());
        
    }
}
