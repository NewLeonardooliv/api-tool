<?php

namespace App\Infra\Http;

use App\Helpers\Validator;

class Request
{
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function body()
    {
        $json = json_decode(file_get_contents('php://input'), true) ?? [];

        $data = match (self::method()) {
            'GET' => $_GET,
            'POST',
            'PUT',
            'DELETE' => $json,
        };

        return $data;
    }

    public static function validate(array $fields, array $values): array
    {
        $validator = new Validator();

        return $validator->validate($fields, $values);
    }
}
