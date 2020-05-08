<?php

namespace App\Repositories\Provinces;

use App\Repositories\BaseRepositoryInterface;

interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    public function getProvincePopulationNearest(int $id);
}
