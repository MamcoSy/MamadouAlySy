<?php

use MamcoSy\Router\Interfaces\RouteInterface;
use MamcoSy\Router\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testNewRoute()
    {
        $route = new Route();

        $this->assertInstanceOf(RouteInterface::class, $route);
        $this->assertEquals('/', $route->getPath());
        $this->assertEquals(null, $route->getCallback());
        $this->assertEquals(null, $route->getMiddleware());
        $this->assertEquals(null, $route->getName());
        $this->assertEquals(null, $route->getParameters());

        $route
            ->setPath('/test/')
            ->setCallback(['TestController', 'index'])
            ->setMiddleware(['Auth', 'Admin'])
            ->setName('test')
            ->setParameters(['id' => 7]);

        $this->assertEquals('/test', $route->getPath());
        $this->assertEquals('test', $route->getName());
        $this->assertEquals(['TestController', 'index'], $route->getCallback());
        $this->assertEquals(['Auth', 'Admin'], $route->getMiddleware());
        $this->assertEquals(['id' => 7], $route->getParameters());
    }
}
