<?php

use MamcoSy\Http\Request;
use PHPUnit\Framework\TestCase;
use MamcoSy\Http\Interfaces\BagInterface;
use MamcoSy\Http\Interfaces\RequestInterface;

class RequestTest extends TestCase
{
    public function testNewRequest()
    {
        $request = new Request();

        $this->assertInstanceOf( RequestInterface::class, $request );
        $this->assertEquals( 'http://localhost', $request->getBaseUrl() );
        $this->assertEquals( '/', $request->getUri() );
        $this->assertEquals( 'GET', $request->getMethod() );
        $this->assertInstanceOf( BagInterface::class, $request->headers );
        $this->assertEmpty( $request->headers->all() );
    }

    public function testNewRequestWithHeaders()
    {
        $request = new Request(
            'http://localhost',
            '/',
            'GET',
            ['Content-Type' => 'text/html']
        );
        $this->assertNotEmpty( $request->headers->all() );
        $this->assertTrue( $request->headers->has( 'content-type' ) );
        $this->assertEquals( 'text/html', $request->headers
                                                     ->get( 'content-type' ) );

        $request->headers->remove( 'content-type' );

        $this->assertNull( $request->headers->get( 'content-type' ) );
        $this->assertFalse( $request->headers->has( 'content-type' ) );
    }

    public function testNewRequestWithAttributes()
    {
        $request = new Request(
            'http://localhost',
            '/',
            'GET',
            ['Content-Type' => 'text/html'],
            ['_controller' => 'TextController', '_action' => 'index']
        );
        $this->assertNotEmpty( $request->attributes->all() );
        $this->assertTrue( $request->attributes->has( '_controller' ) );
        $this->assertTrue( $request->attributes->has( '_action' ) );

        $this->assertEquals( 'TextController', $request->attributes
                                                          ->get( '_controller'
                                                                           ) );
        $this->assertEquals( 'index', $request->attributes->get( '_action' ) );

        $request->attributes->remove( '_controller' );
        $request->attributes->remove( '_action' );

        $this->assertNull( $request->attributes->get( '_controller' ) );
        $this->assertFalse( $request->attributes->has( '_controller' ) );
        $this->assertNull( $request->attributes->get( '_action' ) );
        $this->assertFalse( $request->attributes->has( '_action' ) );
    }

    public function testNewRequestFromGlobals()
    {
        $_SERVER['REQUEST_SCHEME'] = 'https';
        $_SERVER['HTTP_HOST']      = 'google.com';
        $_SERVER['REQUEST_URI']    = '/search';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['name']              = 'Mamadou';
        $request                   = Request::createFromGlobals();

        $this->assertEquals( 'https://google.com', $request->getBaseUrl() );
        $this->assertEquals( '/search', $request->getUri() );
        $this->assertEquals( 'Mamadou', $request->get( 'name' ) );
    }
}
