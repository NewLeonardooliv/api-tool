<?php

namespace App\Infra\Contracts;

use App\Infra\Http\Request;
use App\Infra\Http\Response;

interface Controller
{
    public function handle(Request $request, Response $response);
}
