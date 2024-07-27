<?php

namespace App\Infra\Http\Exceptions;

class UnauthorizedException extends HttpException
{
    protected $statusCode = 401;

    public function __construct($message = 'Unauthorized', $code = 401, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
