<?php

namespace App\Core\Infra\Adapters;

use App\Infra\Contracts\Controller;
use App\Infra\Http\Exceptions\ValidatorException;
use App\Infra\Http\Request;
use App\Infra\Http\Response;

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
            return $this->controller->handle(new Request(), new Response());
        } catch (\Throwable $th) {
            if ($th instanceof ValidatorException) {
                Response::json([$th->getErrors()], $th->getCode());

                return;
            }

            Response::json(['message' => $th->getMessage()], $th->getCode());
        }
    }
}
