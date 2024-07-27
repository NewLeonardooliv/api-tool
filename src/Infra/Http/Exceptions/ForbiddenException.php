<?php

namespace App\Infra\Http\Exceptions;

class ForbiddenException extends HttpException
{
    protected $statusCode = 403;

    public function __construct($message = 'Forbidden', $code = 403, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
