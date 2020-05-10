<?php

namespace App\Http\Transformers;

use App\Repositories\Districts\District;
use League\Fractal\TransformerAbstract;

class DistrictTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
    ];

    public function transform(District $district = null)
    {
        if (is_null($district)) {
            return [];
        }

        return [
            'id'         => $district->id,
            'name'       => $district->name
        ];
    }
}
