<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\UserTransformer;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private UserRepositoryInterface $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
        $this->setTransformer(new UserTransformer());
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        return $this->successResponse($this->user->getById($user->id));
    }

}
