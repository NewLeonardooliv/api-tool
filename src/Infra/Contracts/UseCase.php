<?php

namespace App\Infra\Contracts;

interface UseCase
{
    public function execute(mixed $params);
}
