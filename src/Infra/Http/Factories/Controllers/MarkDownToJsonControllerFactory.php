<?php

namespace App\Infra\Http\Factories\Controllers;

use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Factory;
use App\Modules\MarkDown\UseCases\MarkDownToJson\MarkDownToJsonController;
use App\Modules\MarkDown\UseCases\MarkDownToJson\MarkDownToJsonUseCase;

class MarkDownToJsonControllerFactory implements Factory
{
    public static function create(): Controller
    {
        // $userRepository = InMemoryUserRepository::getInstance();
        $signInUseCase = new MarkDownToJsonUseCase();

        return new MarkDownToJsonController($signInUseCase);
    }
}
