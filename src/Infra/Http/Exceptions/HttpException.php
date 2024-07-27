<?php

namespace App\Infra\Http\Exceptions;

class HttpException extends \Exception
{
    protected $statusCode;

    public function __construct($message = '', $code = 0, ?\Exception $previous = null)
    {
        $this->statusCode = $code;
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
