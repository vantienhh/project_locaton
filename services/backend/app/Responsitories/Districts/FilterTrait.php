<?php

namespace App\Repositories\Districts;

trait FilterTrait
{
    public function scopeProvinceId($query, $provinceId)
    {
        if ($provinceId) {
            return $query->where('province_id', $provinceId);
        }
        return $query;
    }
}
