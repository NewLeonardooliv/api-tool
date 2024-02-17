<?php

namespace App\Infra\Http\Factories\Controllers;

use App\Infra\Contracts\Controller;
use App\Infra\Contracts\Factory;
use App\Modules\Users\Repositories\InMemory\InMemoryUserRepository;
use App\Modules\Users\UseCases\SignIn\SignInController;
use App\Modules\Users\UseCases\SignIn\SignInUseCase;

class SignInControllerFactory implements Factory
{
    public static function create(): Controller
    {
        $userRepository = InMemoryUserRepository::getInstance();
        $signInUseCase = new SignInUseCase($userRepository);

        return new SignInController($signInUseCase);
    }
}
