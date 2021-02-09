<?php

declare(strict_types=1);

namespace MamcoSy\Router\Interfaces;

use MamcoSy\Http\Interfaces\RequestInterface;

interface RouterInterface
{
    public function add(string $method, RouteInterface $route): RouterInterface;

    public function dispatch(RequestInterface $request);
}
