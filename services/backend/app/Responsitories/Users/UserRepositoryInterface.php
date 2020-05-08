<?php

namespace App\Repositories\Users;

use App\Repositories\BaseRepositoryInterface;
use App\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function register(array $data) : User;
}
