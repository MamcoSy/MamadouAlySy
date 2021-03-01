<?php

declare ( strict_types = 1 );

namespace MamcoSy\Middleware;

use MamcoSy\Http\Interfaces\ResponseInterface;

interface MiddlewareInterface
{
    /**
     * @return bool
     */
    public function test(): bool;

    public function handle(): ResponseInterface;
}
