<?php

declare(strict_types=1);

namespace MamcoSy\Http;

use MamcoSy\Http\HttpMessage;
use MamcoSy\Http\Interfaces\ResponseInterface;

class Response extends HttpMessage implements ResponseInterface
{
    protected string $body;
    protected int $statusCode;

    public function __construct(int $statusCode = 200, string $body = '', array $headers = [])
    {
        parent::__construct($headers);
        $this->body       = $body;
        $this->statusCode = $statusCode;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setBody(string $body): ResponseInterface
    {
        $this->body = $body;

        return $this;
    }

    public function setStatusCode(int $statusCode): ResponseInterface
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function send():void
    {
        foreach ($this->getHeaders() as $key => $value) {
            header($key . ': ' . $value);
        }
        http_response_code($this->getStatusCode());

        echo $this->getBody();
    }
}
