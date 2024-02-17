<?php

namespace App\Modules\Users\UseCases\SignIn;

use App\Infra\Contracts\Controller;

class SignUpController implements Controller
{
    private SignUpUseCase $signInUseCase;

    public function __construct(SignUpUseCase $signInUseCase)
    {
        $this->signInUseCase = $signInUseCase;
    }

    public function handle()
    {
        $this->signInUseCase->execute();
    }
}
