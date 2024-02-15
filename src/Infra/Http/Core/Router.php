<?php

namespace App\Infra\Http\Core;

use App\Infra\Contracts\Controller;
use App\Infra\Http\Core\Errors\InvalidRoute;

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

    public static function addRoute(string $method, string $path, Controller $controller)
    {
        self::validate($method, $path);

        self::$routes[$method][$path] = $controller;
    }

    public static function get(string $path, Controller $controller)
    {
        self::addRoute('GET', $path, $controller);
    }

    public static function post(string $path, Controller $controller)
    {
        self::addRoute('POST', $path, $controller);
    }

    public static function put(string $path, Controller $controller)
    {
        self::addRoute('PUT', $path, $controller);
    }

    public static function patch(string $path, Controller $controller)
    {
        self::addRoute('PATCH', $path, $controller);
    }

    public static function delete(string $path, Controller $controller)
    {
        self::addRoute('DELETE', $path, $controller);
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
