<?php

declare(strict_types=1);

namespace MamcoSy\Http;

use MamcoSy\Http\Interfaces\BagInterface;
use MamcoSy\Http\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    protected string $baseUrl;
    protected string $uri;
    protected string $method;
    public BagInterface $headers;
    public BagInterface $attributes;

    public function __construct(
        string $baseUrl = 'http://localhost',
        string $uri = '/',
        string $method = 'GET',
        array $headers = [],
        array $attributes = []
    ) {
        $this->baseUrl     = $baseUrl;
        $this->uri         = $uri;
        $this->method      = $method;
        $this->headers     = new Bag($headers);
        $this->attributes  = new Bag($attributes);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function get(string $key)
    {
    }
}
