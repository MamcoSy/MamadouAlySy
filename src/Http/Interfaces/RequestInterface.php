<?php

declare ( strict_types = 1 );

namespace MamcoSy\Http\Interfaces;

interface RequestInterface
{
    public function getBaseUrl(): string;

    public function getUri(): string;

    public function getMethod(): string;

    public function get( string $key, $defaultValue = null );

    public static function createFromGlobals(): RequestInterface;
}
