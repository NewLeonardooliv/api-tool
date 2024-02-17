<?php

namespace App\Modules\Users\Repositories\InMemory;

use App\Modules\Users\Repositories\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    private function __construct() {}

    public static function getInstance(): UserRepository
    {
        return new InMemoryUserRepository();
    }
}
