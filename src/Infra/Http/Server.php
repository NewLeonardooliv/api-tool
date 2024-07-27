<?php

namespace App\Infra\Http;

use App\Core\Infra\Adapters\RouteAdpter;
use App\Core\Infra\Router;
use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Kernel;
use App\Infra\Contracts\Middleware;
use App\Infra\Http\Exceptions\ValidatorException;

class Server implements Kernel
{
    public static function bootstrap()
    {
        try {
            $controller = self::executeRoute();

            $routeAdpter = new RouteAdpter($controller);
            $routeAdpter->execute();
        } catch (\Throwable $th) {
            if ($th instanceof ValidatorException) {
                Response::json([$th->getErrors()], $th->getCode());

                return;
            }

            Response::json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    private static function executeRoute(): Controller
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $routeProperties = Router::findRoute(Request::method(), $path);

        self::executeMiddlewares($routeProperties['middlewares']);

        return $routeProperties['controller']::create();
    }

    private static function executeMiddlewares(array $middlewares)
    {
        array_map(function (Middleware $middleware) {
            $middleware->handle();
        }, $middlewares);
    }
}
