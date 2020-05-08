<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Entity extends Model
{
    public function scopeSort($query, $sort = 'created_at:-1')
    {
        $sorts = explode(',', $sort);
        foreach ($sorts as $sort) {
            $sort = explode(':', $sort);
            list($field, $type) = [Arr::get($sort, '0', 'created_at'), Arr::get($sort, '1', 1)];
            $query->orderBy($field, $type == 1 ? 'ASC' : 'DESC');
        }
        return $query;
    }
}
