<?php

use App\Core\Infra\Router;
use App\Infra\Http\Factories\Controllers\SignInControllerFactory;

Router::post('/signin', SignInControllerFactory::class);
