<?php

namespace Core\Request;

use Core\Routing\Route;

class Request
{
    private $queries = [];

    private $uri;

    private $route;

    private $exception;

    public function getQuery($key, $default = null) : ?string
    {
        if (!isset($this->queries)) {
            return $default;
        }

        return $this->queries[$key];
    }

    public function addQuery($key, $value)
    {
        $this->queries[$key] = $value;

        return $this;
    }

    public function getQueries() : array
    {
        return $this->queries;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function getUri() : string
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute(Route $route): void
    {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param mixed $exception
     */
    public function setException($exception): void
    {
        $this->exception = $exception;
    }

    public function hasException()
    {
        return $this->getException() != null;
    }
}