<?php

declare ( strict_types = 1 );

namespace MamcoSy\Http;

use MamcoSy\Http\Interfaces\BagInterface;
use MamcoSy\Http\Interfaces\RequestInterface;

class Request extends HttpMessage implements RequestInterface
{
    protected string $baseUrl;
    protected string $uri;
    protected string $method;
    public BagInterface $attributes;

    /**
     * @param string $baseUrl
     * @param string $uri
     * @param string $method
     * @param array  $headers
     * @param array  $attributes
     */
    public function __construct(
        string $baseUrl = 'http://localhost',
        string $uri = '/',
        string $method = 'GET',
        array $headers = [],
        array $attributes = []
    ) {
        $this->baseUrl    = $baseUrl;
        $this->uri        = $uri;
        $this->method     = $method;
        $this->attributes = new Bag( $attributes );
        parent::__construct( $headers );
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param  string          $key
     * @param  $defaultValue
     * @return mixed
     */
    public function get( string $key, $defaultValue = null )
    {

        if ( isset( $_GET[$key] ) ) {
            return $_GET[$key];
        } elseif ( isset( $_POST[$key] ) ) {
            return $_POST[$key];
        } else {
            return $defaultValue;
        }

    }

    public static function createFromGlobals(): RequestInterface
    {
        $protocol = $_SERVER['REQUEST_SCHEME'] ?? 'http';
        $hostname = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $baseUrl  = $protocol . '://' . $hostname;

        return new self(
            $baseUrl,
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            []
        );
    }

}
