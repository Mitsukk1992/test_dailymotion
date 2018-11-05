<?php

namespace Config\Routes;

use Core\Routing\RoutesDeclarationAbstract;


class AppRoutes extends RoutesDeclarationAbstract
{
    public function __construct()
    {
        $this->addRoute('test_routing', '/test/:sid', 'Src\Controller\TestController:test');
    }
}