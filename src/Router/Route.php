<?php

declare ( strict_types = 1 );

namespace MamcoSy\Router;

use MamcoSy\Http\Interfaces\RequestInterface;
use MamcoSy\Router\Interfaces\RouteInterface;
use MamcoSy\Http\Interfaces\ResponseInterface;
use MamcoSy\Router\Exceptions\RouteClassNotFoundException;
use MamcoSy\Router\Exceptions\RouteMethodNotFoundExecption;
use MamcoSy\Router\Exceptions\RouteInvalidCallbackException;

class Route implements RouteInterface
{
    protected  ? string $name;
    protected string $path;
    protected  ? array $callback;
    protected  ? array $parameters = null;
    protected  ? string $middleware;
    const MAP_PATTERN = [
        '#{int:([a-zA-Z\-]+)}#'    => '([0-9]+)',
        '#{string:([a-zA-Z\-]+)}#' => '([a-zA-Z]+)',
        '#{\*:([a-zA-Z\-]+)}#'     => '([0-9a-zA-Z\-]+)',
    ];

    /**
     * @param string     $path
     * @param array      $callback
     * @param array      $middleware
     * @param nullstring $name
     */
    public function __construct(
        string $path = '',
            ?array $callback = null,
            ?string $middleware = null,
            ?string $name = null
    ) {
        $this->path = $path == '' || $path == '/' ? '/' : rtrim( $path,
            '/' );
        $this->callback   = $callback;
        $this->middleware = $middleware;
        $this->name       = $name;
    }

    /**
     * @return mixed
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getCallback() : ?array
    {
        return $this->callback;
    }

    /**
     * @return mixed
     */
    public function getParameters() : ?array
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getMiddleware(): ?string
    {
        return $this->middleware;
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function setName( ?string $name ): RouteInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param  string  $path
     * @return mixed
     */
    public function setPath( string $path ): RouteInterface
    {
        $this->path = rtrim( $path, '/' );

        return $this;
    }

    /**
     * @param  array   $callback
     * @return mixed
     */
    public function setCallback( ?array $callback ): RouteInterface
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @param  array   $parameters
     * @return mixed
     */
    public function setParameters( ?array $parameters ): RouteInterface
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param  string $middleware
     * @return self
     */
    public function setMiddleware( ?string $middleware ): RouteInterface
    {
        $this->middleware = $middleware;

        return $this;
    }

    /**
     * @return mixed
     */
    public function call(): ResponseInterface
    {

        if ( ! is_null( $this->middleware ) ) {
            return $this->getResponse( [$this->getMiddleware(), 'handle'] );
        }

        return $this->getResponse( $this->getCallback() );
    }

    /**
     * @param array $data
     */
    private function getResponse( array $data ): ResponseInterface
    {

        if ( is_array( $data ) ) {
            list( $controller, $action ) = $data;

            if ( class_exists( $controller ) ) {
                $controllerObject = new $controller();

                if ( method_exists( $controllerObject, $action ) ) {
                    return call_user_func_array(
                        [$controllerObject, $action],
                        $this->getParameters()
                    );
                }

                throw new RouteMethodNotFoundExecption(
                    'Invalid ' . $action . ' method in ' . $controller .
                    ' class'
                );
            }

            throw new RouteClassNotFoundException(
                'Invalid ' . $controller . ' class'
            );
        }

        throw new RouteInvalidCallbackException( 'Invlid callback !' );
    }

    /**
     * @param RequestInterface $request
     */
    public function match( RequestInterface $request ): bool
    {
        $pattern = $this->getPattern( $this->getPath() );

        if ( preg_match( $pattern, $request->getUri(), $matches ) ) {
            unset( $matches[0] );
            $this->setParameters( $matches );

            return true;
        }

        return false;
    }

    /**
     * @param  string  $path
     * @return mixed
     */
    private function getPattern( string $path )
    {
        $pattern = '#^' . preg_replace( '#\/#', '\/', $path ) . '$#';

        foreach ( self::MAP_PATTERN as $map => $mapValue ) {
            $pattern = preg_replace( $map, $mapValue, $pattern );
        }

        return $pattern;
    }

}
