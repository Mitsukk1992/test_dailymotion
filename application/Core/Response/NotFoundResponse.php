<?php

namespace Core\Response;

use Core\Exceptions\BadHttpCodeException;

class NotFoundResponse extends Response
{
    public function __construct()
    {
        try {
            $this->setResponseCode(self::HTTP_CODE_NOT_FOUND);
        } catch (\Exception $e) {
            $this->setResponseCode(self::HTTP_CODE_INTERNAL_SERVER_ERROR);
        }
    }
}