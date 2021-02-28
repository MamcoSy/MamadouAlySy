<?php

declare ( strict_types = 1 );

namespace MamcoSy\Http;

use MamcoSy\Http\HttpMessage;
use MamcoSy\Http\Interfaces\ResponseInterface;

class Response extends HttpMessage implements ResponseInterface
{
    protected string $body;
    protected int $statusCode;

    /**
     * @param int    $statusCode
     * @param string $body
     * @param array  $headers
     */
    public function __construct(
        int $statusCode = 200,
        string $body = '',
        array $headers = []
    ) {
        parent::__construct( $headers );
        $this->body       = $body;
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param  string  $body
     * @return mixed
     */
    public function setBody( string $body ): ResponseInterface
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param  int     $statusCode
     * @return mixed
     */
    public function setStatusCode( int $statusCode ): ResponseInterface
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function send(): void
    {

        foreach ( $this->getHeaders() as $key => $value ) {
            header( $key . ': ' . $value );
        }

        http_response_code( $this->getStatusCode() );

        echo $this->getBody();
    }

}
