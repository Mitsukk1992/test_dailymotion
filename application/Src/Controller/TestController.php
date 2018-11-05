<?php

namespace Src\Controller;

use Core\Controller\Controller;
use Core\Request\Request;
use Core\Response\JsonResponse;
use Core\Response\Response;

class TestController extends Controller
{
    public function test(Request $request, array $routeParams)
    {
        extract($routeParams);


        return new JsonResponse(['sid' => $sid]);
    }
}