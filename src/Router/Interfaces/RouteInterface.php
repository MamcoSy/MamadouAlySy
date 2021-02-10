<?php

declare(strict_types=1);

namespace MamcoSy\Router\Interfaces;

use MamcoSy\Http\Interfaces\RequestInterface;
use MamcoSy\Http\Interfaces\ResponseInterface;

interface RouteInterface
{
    public function getName(): ?string;

    public function getPath(): string;

    public function getCallback(): ?array;

    public function getParameters(): ?array;

    public function getMiddleware(): ?array;

    public function setName(?string $name): RouteInterface;

    public function setPath(string $path): RouteInterface;

    public function setCallback(?array $callback): RouteInterface;

    public function setParameters(?array $parameters): RouteInterface;

    public function setMiddleware(?array $middleware): RouteInterface;

    public function call(): ResponseInterface;

    public function match(RequestInterface $request): bool;
}
