<?php

namespace App\Infra\Http\Exceptions;

class BadRequestException extends HttpException
{
    protected $statusCode = 400;

    public function __construct($message = 'Bad Request', $code = 400, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
