<?php

declare(strict_types=1);

namespace MamcoSy\Router\Interfaces;

use MamcoSy\Http\Interfaces\ResponseInterface;

interface RouteInterface
{
    public function getName(): string;

    public function getCallback(): callable;

    public function getParameters(): array;

    public function getMiddleware(): array;

    public function setName(string $name): RouteInterface;

    public function setCallback(callable $callback): RouteInterface;

    public function setParameters(array $parameters): RouteInterface;

    public function setMiddleware(array $middleware): RouteInterface;

    public function call(): ResponseInterface;

    public function match(ResponseInterface $request): bool;
}
