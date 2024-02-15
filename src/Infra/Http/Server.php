<?php

namespace App\Infra\Http;

use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Kernel;
use App\Infra\Contracts\Middleware;
use App\Infra\Http\Core\Router;

class Server implements Kernel
{
    public static function bootstrap()
    {
        try {
            $controller = self::executeRoute();

            $controller->handle();
        } catch (\Throwable $th) {
            print $th->getMessage();
        }
    }

    private static function executeRoute(): Controller
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $routeProperties = Router::findRoute($method, $path);

        self::executeMiddlewares($routeProperties['middlewares']);

        return $routeProperties['controller'];
    }

    private static function executeMiddlewares(array $middlewares)
    {
        array_map(function (Middleware $middleware) {
            $middleware->handle();
        }, $middlewares);
    }
}
