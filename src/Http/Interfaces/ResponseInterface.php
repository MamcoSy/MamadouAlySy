<?php

declare ( strict_types = 1 );

namespace MamcoSy\Http\Interfaces;

interface ResponseInterface
{
    public function getBody(): string;

    public function setBody( string $body ): ResponseInterface;

    public function getStatusCode(): int;

    public function setStatusCode( int $statusCode ): ResponseInterface;

    public function send(): void;
}
