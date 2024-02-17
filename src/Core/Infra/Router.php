<?php

namespace App\Core\Infra;

use App\Core\Infra\Errors\InvalidRoute;
use App\Core\Infra\UseCase\InstanceControllerFactoryUseCase;
use App\Core\Infra\UseCase\InstanceMiddlewaresUseCase;

require __DIR__.'/../../Infra/Http/Routes/Routes.php';

class Router
{
    private const METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    private static array $routes = [];

    public static function findRoute(string $method, string $path)
    {
        if (!self::pathExists($method, $path)) {
            throw new InvalidRoute('Route not found', 404);
        }

        return self::$routes[$method][$path];
    }

    public static function addRoute(string $method, string $path, string $controller, array $middlewares)
    {
        self::validate($method, $path);

        self::$routes[$method][$path] = [
            'controller' => (new InstanceControllerFactoryUseCase())->execute($controller),
            'middlewares' => (new InstanceMiddlewaresUseCase())->execute($middlewares),
        ];
    }

    public static function get(string $path, string $controller, array $middleware = [])
    {
        self::addRoute('GET', $path, $controller, $middleware);
    }

    public static function post(string $path, string $controller, array $middleware = [])
    {
        self::addRoute('POST', $path, $controller, $middleware);
    }

    public static function put(string $path, string $controller, array $middleware = [])
    {
        self::addRoute('PUT', $path, $controller, $middleware);
    }

    public static function patch(string $path, string $controller, array $middleware = [])
    {
        self::addRoute('PATCH', $path, $controller, $middleware);
    }

    public static function delete(string $path, string $controller, array $middleware = [])
    {
        self::addRoute('DELETE', $path, $controller, $middleware);
    }

    private static function validate(string $method, string $path)
    {
        if (!in_array($method, self::METHODS)) {
            throw new InvalidRoute('Invalid HTTP method specified');
        }

        if (self::pathExists($method, $path)) {
            throw new InvalidRoute('Route already exists for the method');
        }
    }

    private static function pathExists(string $method, string $path): bool
    {
        return isset(self::$routes[$method][$path]);
    }
}
