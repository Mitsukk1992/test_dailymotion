<?php

namespace Core;

use Core\Env\EnvLoader;
use Core\Exception\KernelException;
use Core\Exceptions\FatalException;
use Core\Exceptions\HttpException;
use Core\Exceptions\NoRouteFoundException;
use Core\Exceptions\NotFoundException;
use Core\Orm\Orm;
use Core\Request\Request;
use Core\Request\RequestBuilder;
use Core\Response\Response;
use Core\Routing\Route;
use Core\Routing\Router;

class Kernel
{
    public function init($routes) : Request
    {
        $requestBuilder = new RequestBuilder();
        /** @var Request $request */
        $request = $requestBuilder->buildFromGlobal();

        try {
            $envLoader = new EnvLoader();
            $envLoader->loadEnv(ROOT . '.env');

            $router = new Router();
            $router->buildRoutes($routes);


            $request->setRoute($router->getRoute($request));

            //INIT ORM
            $orm = Orm::getInstance();
            $orm->connect($_ENV['DATABASE_HOST'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'], $_ENV['DATABASE_DB']);

            //var_dump($orm->isConnected());die();
        }
        catch (\Exception $e) {
            $request->setException($e);
        }

        return $request;
    }

    public function buildResponse(Request $request) : Response
    {
        try {
            $response = new Response();

            if ($request->hasException()) {
                throw $request->getException();
            }

            /** @var Route $route */
            $route = $request->getRoute();


            if ($route->hasException()) {
                throw $route->getException();

            } else {
                $response = $this->getResponse($request);
            }
        } catch (\Exception $e) {

            $httpCode = Response::HTTP_CODE_INTERNAL_SERVER_ERROR;

            if ($e instanceof HttpException) {
                $httpCode = $e->getCode();
            }

            $response->setResponseCode($httpCode);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

    private function getResponse(Request $request)
    {
        /** @var Route $route */
        $route = $request->getRoute();

        if ($route === null) {
            throw new NoRouteFoundException('No route found in request.');
        }

        $controllerInfo = $route->getController();
        $controllerInfo = explode(':', $controllerInfo);

        if (count($controllerInfo) !== 2) {
            throw new FatalException('Route configuration is bad mkey.');
        }

        $controller = $controllerInfo[0];
        $action = $controllerInfo[1];

        $controllerObj = new $controller;

        $response = $controllerObj->$action($request, $request->getRoute()->getParams());

        if (!($response instanceof Response)) {
            throw new FatalException('Controller must return a response.');
        } else {
            return $response;
        }
    }
}