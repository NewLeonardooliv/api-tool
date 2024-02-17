<?php

namespace App\Infra\Contracts;

interface Factory
{
    public static function create(): Controller;
}
