<?php

declare(strict_types=1);

namespace MamcoSy\Http;

use MamcoSy\Http\Interfaces\BagInterface;
use MamcoSy\Http\Interfaces\RequestInterface;

class Request extends HttpMessage implements RequestInterface
{
    protected string $baseUrl;
    protected string $uri;
    protected string $method;
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
        $this->attributes  = new Bag($attributes);
        parent::__construct($headers);
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

    public function get(string $key, $defaultValue)
    {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        } elseif (isset($_POST[$key])) {
            return $_POST[$key];
        } else {
            return $defaultValue;
        }
    }
}
