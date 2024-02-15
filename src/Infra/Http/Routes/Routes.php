<?php

use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Middleware;
use App\Infra\Http\Core\Router;

class ControllerTest implements Controller
{
    public function handle()
    {
        print 'aqui';
    }
}

class MiddlewareTest implements Middleware
{
    public function handle()
    {
        print 'aqui';
    }
}

Router::get('/leonardo', ControllerTest::class, [MiddlewareTest::class]);
