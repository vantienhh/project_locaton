<?php

namespace App\Http\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
    ];

    public function transform(User $user = null)
    {
        if (is_null($user)) {
            return [];
        }

        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'active'     => $user->active,
            'created_at' => $user->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
