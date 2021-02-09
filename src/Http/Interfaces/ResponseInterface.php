<?php

declare(strict_types=1);

namespace MamcoSy\Http\Interfaces;

interface ResponseInterface
{
    public function getBody(): string;

    public function getStatusCode(): int;
}
