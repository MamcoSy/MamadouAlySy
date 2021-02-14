<?php

use MamcoSy\Http\Request;
use MamcoSy\Router\Route;
use MamcoSy\Router\Router;
use PHPUnit\Framework\TestCase;
use MamcoSy\Router\Interfaces\RouteInterface;

class RouterTest extends TestCase
{
    public function testRouterAdd()
    {
        $request1 = new Request();
        $request2 = new Request('http://localhost', '/test');

        Router::add('GET', new Route('/', [\Tests\Controllers\TextController::class, 'index']));

        $this->assertInstanceOf(RouteInterface::class, Router::dispatch($request1));
        $this->assertNull(Router::dispatch($request2));
    }

    public function testRouterGet()
    {
        $request = new Request('http://localhost', '/test');
        Router::get('/test', '\Tests\Controllers\TextController@index');
        $this->assertInstanceOf(RouteInterface::class, Router::dispatch($request));
    }
}
