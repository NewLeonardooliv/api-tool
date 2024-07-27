<?php

namespace App\Modules\MarkDown\UseCases\MarkDownToJson;

use App\Helpers\Validator;
use App\Infra\Contracts\Controller;
use App\Infra\Http\Request;
use App\Infra\Http\Response;

class MarkDownToJsonController implements Controller
{
    private MarkDownToJsonUseCase $markDownToJsonUseCase;

    public function __construct(MarkDownToJsonUseCase $markDownToJsonUseCase)
    {
        $this->markDownToJsonUseCase = $markDownToJsonUseCase;
    }

    public function handle(Request $request, Response $response)
    {
        $fields = ['markdown' => ['required' => true, 'type' => 'string']];
        $data = $request::validate($fields, $request::body());

        $json = $this->markDownToJsonUseCase->execute($data['markdown']);

        $response::json($json);
    }
}
