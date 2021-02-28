<?php

declare ( strict_types = 1 );

namespace MamcoSy\Http;

use MamcoSy\Http\Interfaces\BagInterface;

class Bag implements BagInterface
{
    protected array $storage = [];

    /**
     * @param array $data
     */
    public function __construct( array $data )
    {

        foreach ( $data as $key => $value ) {
            $this->set( $key, $value );
        }

    }

    /**
     * @return mixed
     */
    public function all(): array
    {
        return $this->storage;
    }

    /**
     * @inheritDoc
     */
    public function get( string $key )
    {

        if ( $this->has( $key ) ) {
            return $this->storage[strtolower( $key )];
        }

        return null;
    }

    /**
     * @param  string   $key
     * @param  $value
     * @return mixed
     */
    public function set( string $key, $value ): BagInterface
    {
        $this->storage[strtolower( $key )] = $value;

        return $this;
    }

    /**
     * @param string $key
     */
    public function has( string $key ): bool
    {
        return isset( $this->storage[strtolower( $key )] );
    }

    /**
     * @param  string  $key
     * @return mixed
     */
    public function remove( string $key ): BagInterface
    {
        unset( $this->storage[strtolower( $key )] );

        return $this;
    }

}
