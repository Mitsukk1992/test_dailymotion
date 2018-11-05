<?php

namespace Core\Request;

use Core\Routing\Route;

class RequestBuilder
{
    public function buildFromGlobal() : Request
    {
        $request = new Request();

        foreach ($_GET as $key => $value) {
            $request->addQuery($key, $value);
        }


        $request->setUri($_SERVER['REQUEST_URI']);

        return $request;
    }
}