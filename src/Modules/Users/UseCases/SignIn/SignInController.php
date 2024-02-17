<?php

namespace App\Modules\Users\UseCases\SignIn;

use App\Infra\Contracts\Controller;

class SignInController implements Controller
{
    private SignInUseCase $signInUseCase;

    public function __construct(SignInUseCase $signInUseCase)
    {
        $this->signInUseCase = $signInUseCase;
    }

    public function handle()
    {
        $this->signInUseCase->execute();
    }
}
