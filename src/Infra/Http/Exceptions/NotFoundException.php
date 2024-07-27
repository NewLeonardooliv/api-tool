<?php

namespace App\Infra\Http\Exceptions;

class NotFoundException extends HttpException
{
    protected $statusCode = 404;

    public function __construct($message = "Not Found", $code = 404, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}