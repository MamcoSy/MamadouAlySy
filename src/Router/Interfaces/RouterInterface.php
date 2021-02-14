<?php

declare(strict_types=1);

namespace MamcoSy\Router\Interfaces;

use MamcoSy\Http\Interfaces\RequestInterface;
use MamcoSy\Router\Interfaces\RouteInterface;

interface RouterInterface
{
    public static function add(string $method, RouteInterface $route): void;

    public static function dispatch(RequestInterface $request): ?RouteInterface;
}
