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

    const MAP_PATTERN = [
        '#{int:([a-zA-Z\-]+)}#'    => '([0-9]+)',
        '#{string:([a-zA-Z\-]+)}#' => '([a-zA-Z]+)',
        '#{\*:([a-zA-Z\-]+)}#'     => '([0-9a-zA-Z\-]+)',
    ];

    /**
     * @param string      $path
     * @param null|array  $callback
     * @param null|array  $middleware
     * @param null|string $name
     */
    public function __construct(
        string $path = '',
            ?array $callback = null,
            ?string $name = null
    ) {
        $this
            ->setPath( $path )
            ->setCallback( $callback )
            ->setName( $name )
        ;
    }

    /**
     * @inheritDoc
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getCallback() : ?array
    {
        return $this->callback;
    }

    /**
     * @inheritDoc
     */
    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    /**
     * @inheritDoc
     */
    public function setName( ?string $name ): RouteInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPath( string $path ): RouteInterface
    {
        $this->path = '/' . trim( $path, '/' );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCallback( ?array $callback ): RouteInterface
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setParameters( ?array $parameters ): RouteInterface
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param array $callback
     */
    private function _invoke( array $callback ): ResponseInterface
    {

        if ( is_array( $callback ) ) {
            list( $controller, $action ) = $callback;

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
     * @inheritDoc
     */
    public function call(): ResponseInterface
    {
        return $this->_invoke( $this->callback );
    }

    /**
     * @inheritDoc
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
     * Generating the regex pattern
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
