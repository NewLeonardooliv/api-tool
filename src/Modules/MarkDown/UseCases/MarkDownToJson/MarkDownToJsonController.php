<?php

namespace App\Modules\MarkDown\UseCases\MarkDownToJson;

use App\Infra\Contracts\Controller;

class MarkDownToJsonController implements Controller
{
    private MarkDownToJsonUseCase $markDownToJsonUseCase;

    public function __construct(MarkDownToJsonUseCase $markDownToJsonUseCase)
    {
        $this->markDownToJsonUseCase = $markDownToJsonUseCase;
    }

    public function handle()
    {
        return $this->markDownToJsonUseCase->execute();
    }
}
