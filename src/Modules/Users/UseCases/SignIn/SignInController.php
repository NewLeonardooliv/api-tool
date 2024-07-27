<?php

namespace App\Modules\Users\UseCases\SignIn;

use App\Infra\Contracts\Controller;
use App\Infra\Http\Request;
use App\Infra\Http\Response;

class SignInController implements Controller
{
    private SignInUseCase $signInUseCase;

    public function __construct(SignInUseCase $signInUseCase)
    {
        $this->signInUseCase = $signInUseCase;
    }

    public function handle(Request $request, Response $response)
    {
        $this->signInUseCase->execute();
    }
}
