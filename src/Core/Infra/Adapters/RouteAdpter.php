<?php

namespace App\Core\Infra\Adapters;

use App\Infra\Contracts\Controller;

class RouteAdpter
{
    private Controller $controller;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function execute()
    {
        try {
            return $this->controller->handle();
        } catch (\Throwable $th) {
            ['message' => $th->getMessage()];
        }
    }
}
