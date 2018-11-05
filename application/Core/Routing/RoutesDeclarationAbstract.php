<?php

namespace Core\Routing;

abstract class RoutesDeclarationAbstract implements RoutesDeclarationInterface
{
    private $routes;

    public function addRoute($routeName, $routeRegexPath, $controllerName, $options = [])
    {
        $route = new Route($routeName, $routeRegexPath, $controllerName, $options);

        $this->routes[] = $route;
    }

    public function getRoutes() : array
    {
        return $this->routes;
    }
}