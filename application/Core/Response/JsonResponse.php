<?php

namespace Core\Response;

use Core\Exceptions\BadHttpCodeException;

class JsonResponse extends Response
{
    public function __construct($content = '', $httpCode = Response::HTTP_CODE_OK)
    {
        parent::__construct();

        $this->setContent(json_encode($content));
        $this->setContentType('application/json');
        $this->setResponseCode($httpCode);
    }
}