<?php

namespace App\Http\Transformers;

use App\Repositories\Provinces\Province;
use League\Fractal\TransformerAbstract;

class ProvinceTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
    ];

    public function transform(Province $province = null)
    {
        if (is_null($province)) {
            return [];
        }

        return [
            'id'         => $province->id,
            'name'       => $province->name,
            'created_at' => $province->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
