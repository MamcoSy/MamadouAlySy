<?php

declare ( strict_types = 1 );

namespace MamcoSy\Router;

use MamcoSy\Http\Interfaces\RequestInterface;
use MamcoSy\Router\Interfaces\RouteInterface;
use MamcoSy\Router\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var array
     */
    public static $routeCollection = [];

    /**
     * @param string         $method
     * @param RouteInterface $route
     */
    public static function add( string $method, RouteInterface $route ): void
    {
        static::$routeCollection[$method][] = $route;
    }

    /**
     * @param string $path
     * @param string $callback
     */
    public static function get( string $path, string $callback )
    {
        list( $controller, $action ) = explode( '@', $callback );
        static::add( 'GET', new Route( $path, [$controller, $action] ) );
    }

    /**
     * @param string $path
     * @param string $callback
     */
    public static function post( string $path, string $callback )
    {
        list( $controller, $action ) = explode( '@', $callback );
        static::add( 'POST', new Route( $path, [$controller, $action] ) );
    }

    /**
     * @param  RequestInterface $request
     * @return mixed
     */
    public static function dispatch(
        RequestInterface $request
    ): ?RouteInterface {

        foreach ( static::$routeCollection[$request->getMethod()] as $route ) {

            if ( $route->match( $request ) ) {
                return $route;
            }

        }

        return null;
    }

}
