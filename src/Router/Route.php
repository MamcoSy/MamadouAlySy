<?php

declare(strict_types=1);

namespace MamcoSy\Router;

use MamcoSy\Http\Response;
use MamcoSy\Router\Interfaces\RouteInterface;
use MamcoSy\Http\Interfaces\ResponseInterface;

class Route implements RouteInterface
{
    protected ?string $name;
    protected string $path;
    protected ?array $callback;
    protected ?array $parameters = null;
    protected ?array $middleware;

    public function __construct(
        string $path = '',
        ?array $callback = null,
        ?array $middleware = null,
        ?string $name = null
    ) {
        $this->path       = $path == '' ? '/' : $path;
        $this->callback   = $callback;
        $this->middleware = $middleware;
        $this->name       = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCallback(): ?array
    {
        return $this->callback;
    }

    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    public function getMiddleware(): ?array
    {
        return $this->middleware;
    }

    public function setName(?string $name): RouteInterface
    {
        $this->name = $name;

        return $this;
    }

    public function setPath(string $path): RouteInterface
    {
        $this->path = rtrim($path, '/');

        return $this;
    }

    public function setCallback(?array $callback): RouteInterface
    {
        $this->callback = $callback;

        return $this;
    }

    public function setParameters(?array $parameters): RouteInterface
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function setMiddleware(?array $middleware): RouteInterface
    {
        $this->middleware = $middleware;

        return $this;
    }

    public function call(): ResponseInterface
    {
        return new Response();
    }

    public function match(ResponseInterface $request): bool
    {
        return true;
    }
}
