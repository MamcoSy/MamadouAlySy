<?php

namespace Tests\Middlewares;

use MamcoSy\Http\Response;
use MamcoSy\Middleware\MiddlewareInterface;
use MamcoSy\Http\Interfaces\ResponseInterface;

class TestMiddleware implements MiddlewareInterface
{
    /**
     * @return bool
     */
    public function test(): bool
    {
        return false;
    }

    public function handle(): ResponseInterface
    {
        return new Response( 301, 'middleware', ['Location' => '/'] );
    }
}
