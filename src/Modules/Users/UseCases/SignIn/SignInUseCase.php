<?php

namespace App\Modules\Users\UseCases\SignIn;

use App\Modules\Users\Repositories\UserRepository;

class SignInUseCase
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute() {}
}
