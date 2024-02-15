<?php

namespace App\Infra\Http\Core;

use App\Infra\Contracts\Controller;
use App\Infra\Http\Core\Errors\InvalidRoute;

class Router
{
    private const GET = 'GET';
    private const POST = 'POST';
    private const PUT = 'PUT';
    private const PATH = 'PATH';

    public static array $routes;

    public static function findRoute(string $method, string $path)
    {
        if (!self::pathExists($method, $path)) {
            throw new InvalidRoute('Route not found', 404);
        }

        return self::$routes[$method][$path];
    }

    public static function post(string $path, Controller $controller)
    {
        self::$routes[self::POST][$path] = $controller;
    }

    public static function get(string $path, Controller $controller)
    {
        self::$routes[self::GET][$path] = $controller;
    }

    public static function put(string $path, Controller $controller)
    {
        self::$routes[self::PUT][$path] = $controller;
    }

    public static function path(string $path, Controller $controller)
    {
        self::$routes[self::PATH][$path] = $controller;
    }

    private static function validate(string $method, string $path)
    {
        if (self::pathExists($method, $path)) {
            throw new InvalidRoute('Method already exists.');
        }
    }

    private static function pathExists(string $method, string $path): bool
    {
        return isset(self::$routes[$method][$path]);
    }
}
