<?php

namespace Core\Routing;

class Route
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    const VALID_METHODS = [
        self::METHOD_DELETE,
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PUT
    ];

    private $name;

    private $path;

    private $controller;

    private $method;

    private $exception;

    private $params;

    public function __construct($routeName = null, $routePath = null, $routeController = null, $routeOptions = null)
    {
        $this->name = $routeName;
        $this->path = $routePath;
        $this->controller = $routeController;
        $this->exception = null;
        $this->params = [];

        if ($routeOptions != null) {
            $this->extractOptions($routeOptions);
        }
    }

    private function extractOptions($options)
    {
        if (isset($options['method']) && in_array($options['method'], self::VALID_METHODS)) {
            $this->method = $options['method'];
        }
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    public function getException() : \Exception
    {
        return $this->exception;
    }

    public function hasException() : bool
    {
        return $this->exception !== null;
    }

    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}