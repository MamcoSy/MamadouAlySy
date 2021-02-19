<?php

declare(strict_types=1);

namespace MamcoSy\Router;

use MamcoSy\Http\Interfaces\RequestInterface;
use MamcoSy\Router\Interfaces\RouteInterface;
use MamcoSy\Router\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    public static $routeCollection = [];

    public static function add(string $method, RouteInterface $route): void
    {
        static::$routeCollection[$method][] = $route;
    }

    public static function get(string $path, string $callback)
    {
        list($controller, $action) = explode('@', $callback);
        static::add('GET', new Route($path, [$controller, $action]));
    }

    public static function post(string $path, string $callback)
    {
        list($controller, $action) = explode('@', $callback);
        static::add('POST', new Route($path, [$controller, $action]));
    }

    public static function dispatch(RequestInterface $request): ?RouteInterface
    {
        foreach (static::$routeCollection[$request->getMethod()] as $route)
        {
            if ($route->match($request))
            {
                return $route;
            }
        }

        return null;
    }
}
