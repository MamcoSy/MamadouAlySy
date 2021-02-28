<?php

declare ( strict_types = 1 );

namespace MamcoSy\Http;

use MamcoSy\Http\Bag;
use MamcoSy\Http\Interfaces\BagInterface;
use MamcoSy\Http\Interfaces\HttpMessageInterface;

class HttpMessage implements HttpMessageInterface
{

    public BagInterface $headers;

    /**
     * @param  array  $headers
     * @return void
     */
    public function __construct( array $headers )
    {
        $this->headers = new Bag( $headers );
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers->all();
    }
}
