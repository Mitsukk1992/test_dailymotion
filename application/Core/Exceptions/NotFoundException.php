<?php

namespace Core\Exceptions;

class NotFoundException extends HttpException
{
    public function __construct(string $resource, $previous = null)
    {
        $code = 404;

        parent::__construct($resource, $code, $previous);
    }
}