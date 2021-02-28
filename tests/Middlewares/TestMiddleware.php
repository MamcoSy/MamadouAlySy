<?php

namespace Tests\Middlewares;

use MamcoSy\Http\Response;

class TestMiddleware
{
    public function handle()
    {
        return new Response( 301, 'middleware', ['Location' => '/'] );
    }
}
