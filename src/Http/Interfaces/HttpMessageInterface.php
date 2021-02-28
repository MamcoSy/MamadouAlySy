<?php

declare ( strict_types = 1 );

namespace MamcoSy\Http\Interfaces;

interface HttpMessageInterface
{
    public function getHeaders(): array;
}
