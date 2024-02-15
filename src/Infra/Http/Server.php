<?php

namespace App\Infra\Http;

use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Kernel;
use App\Infra\Http\Core\Router;

require __DIR__.'/Routes/Routes.php';

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
        $path = $_SERVER['REQUEST_URI'];

        // print '<pre>';
        // print_r(Router::$routes[$method][$path]);
        // print '<\pre>';

        return Router::findRoute($method, $path);
    }
}
