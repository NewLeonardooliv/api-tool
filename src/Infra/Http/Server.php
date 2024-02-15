<?php

namespace App\Infra\Http;

use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Kernel;
use App\Infra\Http\Core\Router;

class Server implements Kernel
{
    public static function bootstrap()
    {
        try {
            $controller = self::findController();

            $controller->handle();
        } catch (\Throwable $th) {
            print $th->getMessage();
        }
    }

    private static function findController(): Controller
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        return Router::findRoute($method, $path);
    }
}
