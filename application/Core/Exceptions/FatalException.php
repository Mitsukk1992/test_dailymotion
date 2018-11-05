<?php

namespace Core\Exceptions;

use Core\Response\Response;

class FatalException extends HttpException
{
    public function __construct(string $resource, $previous = null)
    {
        $code = Response::HTTP_CODE_INTERNAL_SERVER_ERROR;

        parent::__construct($resource, $code, $previous);
    }
}