<?php

namespace App\Core\Infra\UseCase;

use App\Infra\Contracts\Controller as ContractsController;

class InstanceController
{
    public function execute(string $controller): ContractsController
    {
        $controller = new $controller();

        if ($this->isValid($controller)) {
            throw new \InvalidArgumentException('A controller must implement Controller interface');
        }

        return $controller;
    }

    private function isValid($middleware)
    {
        return $middleware instanceof Middleware;
    }
}
