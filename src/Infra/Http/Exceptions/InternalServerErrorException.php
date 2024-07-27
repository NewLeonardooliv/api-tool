<?php

namespace App\Infra\Http\Exceptions;

class InternalServerErrorException extends HttpException
{
    protected $statusCode = 500;

    public function __construct($message = 'Internal Server Error', $code = 500, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
