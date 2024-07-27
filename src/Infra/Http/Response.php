<?php 

namespace App\Infra\Http;

class Response
{
    public static function json(array $data = [], int $status = 200)
    {
        http_response_code($status);

        header("Content-Type: application/json");

        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}