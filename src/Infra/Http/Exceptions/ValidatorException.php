<?php

namespace App\Infra\Http\Exceptions;

class ValidatorException extends HttpException
{
    protected $statusCode = 400;
    private $errors;

    public function __construct(array $errors, $code = 400, ?\Exception $previous = null)
    {
        $this->setErrors($errors);
        parent::__construct('Validade Exception', $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(array $errors)
    {
        return $this->errors = $errors;
    }
}
