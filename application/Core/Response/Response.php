<?php

namespace Core\Response;

use Core\Exceptions\BadHttpCodeException;

class Response
{
    const HTTP_CODE_OK = 200;
    const HTTP_CODE_NOT_FOUND = 404;
    const HTTP_CODE_INTERNAL_SERVER_ERROR = 500;

    const VALID_HTTP_CODE = [
        self::HTTP_CODE_NOT_FOUND,
        self::HTTP_CODE_OK,
        self::HTTP_CODE_INTERNAL_SERVER_ERROR
    ];

    const DEFAULT_CONTENT_TYPE = 'text/html; charset=utf-8';

    private $responseCode;

    private $content;

    private $contentType;

    public function __construct($content = '')
    {
        $this->setResponseCode(self::HTTP_CODE_OK);
        $this->setContent($content);
        $this->setContentType(self::DEFAULT_CONTENT_TYPE);
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param $responseCode
     * @throws BadHttpCodeException
     */
    public function setResponseCode($responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    public function send()
    {
        if (!in_array($this->getResponseCode(), self::VALID_HTTP_CODE)) {
            throw new BadHttpCodeException('Bad http code');
        }

        http_response_code($this->getResponseCode());
        header('Content-Type: ' . $this->getContentType());

        echo $this->getContent();
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     */
    public function setContentType($contentType): void
    {
        $this->contentType = $contentType;
    }
}