<?php

use MamcoSy\Http\HttpMessage;
use MamcoSy\Http\Interfaces\HttpMessageInterface;
use PHPUnit\Framework\TestCase;

class HttpMessageTest extends TestCase
{
    public function testNewHttpMessage()
    {
        $httpMessage = new HttpMessage([]);

        $this->assertInstanceOf(HttpMessageInterface::class, $httpMessage);
    }

    public function testHttpMessageWithData()
    {
        $httpMessage = new HttpMessage([
            'Content-Type'                => 'text/html; charset=utf-8',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Max-Age'      => 3600
        ]);

        $headers = $httpMessage->getHeaders();

        $this->assertNotEmpty($headers);
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertEquals('text/html; charset=utf-8', $httpMessage->headers->get('Content-Type'));
        $this->assertEquals('*', $httpMessage->headers->get('Access-Control-Allow-Origin'));
        $this->assertEquals(3600, $httpMessage->headers->get('Access-Control-Max-Age'));
    }
}
