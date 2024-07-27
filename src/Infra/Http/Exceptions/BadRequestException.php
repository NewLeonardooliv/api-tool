<?php

namespace App\Infra\Http\Exceptions;

class BadRequestException extends HttpException
{
    protected $statusCode = 500;

    public function __construct($message = 'Bad Request', $code = 500, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
