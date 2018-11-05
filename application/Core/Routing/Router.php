<?php

namespace Core\Routing;

use Core\Exceptions\NotFoundException;
use Core\Exceptions\RouteLoaderException;
use Core\Request\Request;

class Router
{
    private $routes = [];

    public function buildRoutes($routesClass)
    {
        try {
            $this->getRoutes($routesClass);
        } catch (\Exception $e) {
            throw new RouteLoaderException('RouteLoaderException', $e->getCode(), $e);
        }

    }

    public function getRoute(Request $request) : Route
    {
        $uri = $request->getUri();

        /** @var Route $route */
        foreach ($this->routes as $route) {

//            if (preg_match('/\\'.$route->getPath().'\/{?([^\/}]+)}?/', $uri) > 0) {
//                return $route;
//            }

            $patternAsRegex = $this->getRegex($route->getPath());

            if ($ok = !!$patternAsRegex) {
                if ($ok = preg_match($patternAsRegex, $uri, $matches)) {
                    $params = array_intersect_key(
                        $matches,
                        array_flip(array_filter(array_keys($matches), 'is_string'))
                    );

                    $route->setParams($params);

                    return $route;
                }
            }

        }

        $route = new Route();
        $route->setException( new NotFoundException($uri . ' not found.'));

        return $route;
    }

    private function getRoutes($routesClass)
    {
        foreach ($routesClass as $class) {
            /** @var RoutesDeclarationInterface $obj */
            $obj = new $class;
            $this->routes = array_merge($this->routes, $obj->getRoutes());
        }
    }

    private function getRegex($pattern)
    {
        //THANKS STACK OVERFLOW !
        if (preg_match('/[^-:\/_{}()a-zA-Z\d]/', $pattern))
            return false; // Invalid pattern

        $pattern = preg_replace('#\(/\)#', '/?', $pattern);

        $allowedParamChars = '[a-zA-Z0-9\_\-]+';
        $pattern = preg_replace(
            '/:(' . $allowedParamChars . ')/',   # Replace ":parameter"
            '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
            $pattern
        );

        $pattern = preg_replace(
            '/{('. $allowedParamChars .')}/',    # Replace "{parameter}"
            '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
            $pattern
        );

        $patternAsRegex = "@^" . $pattern . "$@D";

        return $patternAsRegex;
    }
}