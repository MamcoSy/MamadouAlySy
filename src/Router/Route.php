<?php

declare(strict_types=1);

namespace MamcoSy\Router;

use MamcoSy\Http\Interfaces\RequestInterface;
use MamcoSy\Router\Interfaces\RouteInterface;
use MamcoSy\Http\Interfaces\ResponseInterface;
use MamcoSy\Router\Exceptions\RouteClassNotFoundException;
use MamcoSy\Router\Exceptions\RouteMethodNotFoundExecption;
use MamcoSy\Router\Exceptions\RouteInvalidCallbackException;

class Route implements RouteInterface
{
    protected ?string $name;
    protected string $path;
    protected ?array $callback;
    protected ?array $parameters = null;
    protected ?array $middleware;
    const MAP_PATTERN = [
        '#{int:([a-zA-Z\-]+)}#'    => '([0-9]+)',
        '#{string:([a-zA-Z\-]+)}#' => '([a-zA-Z]+)',
        '#{\*:([a-zA-Z\-]+)}#'     => '([0-9a-zA-Z\-]+)'
    ];

    public function __construct(
        string $path = '',
        ?array $callback = null,
        ?array $middleware = null,
        ?string $name = null
    ) {
        $this->path       = $path == '' || $path == '/' ? '/' : rtrim($path, '/');
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
        if (is_array($this->getCallback())) {
            list($controller, $action) = $this->getCallback();
            if (class_exists($controller)) {
                $controllerObject = new $controller;
                if (method_exists($controllerObject, $action)) {
                    return call_user_func_array([$controllerObject, $action], $this->getParameters());
                }
                throw new RouteMethodNotFoundExecption('Invalid ' . $action . ' method in ' . $controller . ' class');
            }
            throw new RouteClassNotFoundException('Invalid ' . $controller . ' class');
        }
        throw new RouteInvalidCallbackException('Invlid callback !');
    }

    public function match(RequestInterface $request): bool
    {
        $pattern = $this->getPattern($this->getPath());

        if (preg_match($pattern, $request->getUri(), $matches)) {
            $this->setParameters($matches);

            return true;
        }

        return false;
    }

    private function getPattern(string $path)
    {
        $pattern = '#^' . preg_replace('#\/#', '\/', $path) . '$#';

        foreach (self::MAP_PATTERN as $map => $mapValue) {
            $pattern = preg_replace($map, $mapValue, $pattern);
        }

        return  $pattern;
    }
}
