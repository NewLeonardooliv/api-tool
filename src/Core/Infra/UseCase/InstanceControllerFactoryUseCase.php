<?php

namespace App\Core\Infra\UseCase;

use App\Infra\Contracts\Factory;

class InstanceControllerFactoryUseCase
{
    public function execute(string $controller): Factory
    {
        $controller = new $controller();

        if (!$this->isValid($controller)) {
            throw new \InvalidArgumentException('A controller must implement Factory interface');
        }

        return $controller;
    }

    private function isValid($controllerFactory)
    {
        return $controllerFactory instanceof Factory;
    }
}
