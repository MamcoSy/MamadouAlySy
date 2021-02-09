<?php

use MamcoSy\Http\Response;
use PHPUnit\Framework\TestCase;
use MamcoSy\Http\Interfaces\ResponseInterface;

class ResponseTest extends TestCase
{
    public function testNewResponse()
    {
        $response = new Response();

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testNewResponseWithParams()
    {
        $response = new Response(404, 'Page not found!', ['Content-Type' => 'text/html']);

        $this->assertEquals('text/html', $response->headers->get('Content-Type'));
        $this->assertEquals('Page not found!', $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());

        $response->setBody('hello')->setStatusCode(200)->headers->set('Content-Type', 'application/json');

        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals('hello', $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
