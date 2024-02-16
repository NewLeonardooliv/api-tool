<?php

use App\Core\Infra\Router;
use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Middleware;

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
Router::post('/leonardo', ControllerTest::class, [MiddlewareTest::class]);
