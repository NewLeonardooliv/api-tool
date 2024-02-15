<?php

namespace App\Infra\Http\Core\UseCases;

class Middlewares
{
    public function execute(array $middlewares): array
    {
        if (empty($middlewares)) {
            return [];
        }

        $middlewaresInstantiateds = [];
        foreach ($middlewares as $middleware) {
            $middleware = new $middleware();

            if ($this->isValid($middleware)) {
                throw new \InvalidArgumentException('All middlewares must implement Middleware interface');
            }

            $middlewaresInstantiateds[] = $middleware;
        }

        return $middlewaresInstantiateds;
    }

    private static function isValid($middleware)
    {
        return $middleware instanceof Middleware;
    }
}
