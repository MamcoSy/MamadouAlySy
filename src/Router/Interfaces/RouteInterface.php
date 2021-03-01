<?php

declare ( strict_types = 1 );

namespace MamcoSy\Router\Interfaces;

use MamcoSy\Http\Interfaces\RequestInterface;
use MamcoSy\Http\Interfaces\ResponseInterface;

interface RouteInterface
{
    /**
     * Returns the route name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Returns the route path
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Returns the route callback
     *
     * @return array|null
     */
    public function getCallback(): ?array;

    /**
     * Returns the route parameters
     *
     * @return array|null
     */
    public function getParameters(): ?array;

    /**
     * Returns the route middleware
     *
     * @return array|null
     */
    public function getMiddleware(): ?array;

    /**
     * Setting the route name
     *
     * @param  string|null $name
     * @return self
     */
    public function setName( ?string $name ): self;

    /**
     * Setting the route
     *
     * @param  string $path
     * @return self
     */
    public function setPath( string $path ): self;

    /**
     * Setting the route callback
     *
     * @param  array|null $callback
     * @return self
     */
    public function setCallback( ?array $callback ): self;

    /**
     * Setting the route parameters
     *
     * @param  array|null $parameters
     * @return self
     */
    public function setParameters( ?array $parameters ): self;

    /**
     * Setting the route middleware
     *
     * @param  string|null $middleware
     * @return self
     */
    public function setMiddleware( ?array $middleware ): self;

    /**
     * Call the route
     *
     * @return ResponseInterface
     */
    public function call(): ResponseInterface;

    /**
     * Check if route match the given url
     *
     * @param  RequestInterface $request
     * @return boolean
     */
    public function match( RequestInterface $request ): bool;
}
