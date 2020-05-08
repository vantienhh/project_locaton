<?php

namespace App\Repositories\Users;

use App\Repositories\BaseRepository;
use App\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->setModel($user);
    }

    public function register(array $data) : User
    {
        return $this->store([
            'name'     => $data['name'],
            'password' => bcrypt($data['password']),
            'email'    => $data['email']
        ]);
    }
}
