<?php

namespace App\Repositories\Districts;

use App\Repositories\BaseRepositoryInterface;

interface DistrictRepositoryInterface extends BaseRepositoryInterface
{
    public function getPopulationNearest($id);
}
