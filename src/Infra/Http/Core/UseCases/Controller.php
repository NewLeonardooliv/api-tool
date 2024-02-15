<?php

namespace App\Infra\Http\Core\UseCases;

use App\Infra\Contracts\Controller as ContractsController;

class Controller
{
    public function execute(string $controller): ContractsController
    {
        $controller = new $controller();

        if ($this->isValid($controller)) {
            throw new \InvalidArgumentException('A controller must implement Controller interface');
        }

        return $controller;
    }

    private static function isValid($middleware)
    {
        return $middleware instanceof Middleware;
    }
}
