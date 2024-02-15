<?php

use App\Infra\Contracts\Controller;
use App\Infra\Http\Core\Router;

class MeuController implements Controller
{
    public function handle()
    {
        print 'aqui';
    }
}

Router::get('/leonardo', new MeuController());
Router::post('leonardo', new MeuController());
