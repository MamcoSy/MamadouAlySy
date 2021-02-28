<?php

use MamcoSy\Http\Request;
use MamcoSy\Router\Route;
use PHPUnit\Framework\TestCase;
use Tests\Controllers\TestController;
use MamcoSy\Router\Interfaces\RouteInterface;
use MamcoSy\Http\Interfaces\ResponseInterface;

class RouteTest extends TestCase
{
    public function testNewRoute()
    {
        $route = new Route();

        $this->assertInstanceOf( RouteInterface::class, $route );
        $this->assertEquals( '/', $route->getPath() );
        $this->assertEquals( null, $route->getCallback() );
        $this->assertEquals( null, $route->getMiddleware() );
        $this->assertEquals( null, $route->getName() );
        $this->assertEquals( null, $route->getParameters() );

        $route
            ->setPath( '/test/' )
            ->setCallback( ['TestController', 'index'] )
            ->setMiddleware( 'Admin' )
            ->setName( 'test' )
            ->setParameters( ['id' => 7] );

        $this->assertEquals( '/test', $route->getPath() );
        $this->assertEquals( 'test', $route->getName() );
        $this->assertEquals(
            ['TestController', 'index'],
            $route->getCallback()
        );
        $this->assertEquals( 'Admin', $route->getMiddleware() );
        $this->assertEquals( ['id' => 7], $route->getParameters() );
    }

    public function testRouteMatch()
    {
        $route = new
        Route( '/user/{int:id}/edit/{string:full-name}/{*:hash}/test' );
        $request = new Request( 'http://localhost',
            '/user/8/edit/MamadouAlySy/71az2z-z8z9z/test' );

        $this->assertTrue( $route->match( $request ) );
    }

    public function testRouteCall()
    {
        $request = new Request();
        $route   = new Route(
            '/',
            [\Tests\Controllers\TestController::class, 'index']
        );

        $this->assertTrue( $route->match( $request ) );

        $response = $route->call();

        $this->assertInstanceOf( ResponseInterface::class, $response );
        $this->assertEquals( 'hello', $response->getBody() );
    }

    public function testRouteCallWithMiddleware()
    {
        $request = new Request();
        $route   = new Route(
            '/',
            [\Tests\Controllers\TestController::class, 'index'],
            \Tests\Middlewares\TestMiddleware::class
        );

        $this->assertTrue( $route->match( $request ) );

        $response = $route->call();

        $this->assertEquals( 'middleware', $response->getBody() );
    }
}
