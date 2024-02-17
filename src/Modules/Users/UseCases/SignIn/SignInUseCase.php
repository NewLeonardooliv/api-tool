<?php

namespace App\Modules\Users\UseCases\SignIn;

use App\Infra\Contracts\UseCase;
use App\Modules\Users\Repositories\UserRepository;

class SignInUseCase implements UseCase
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute() {}
}
