<?php

namespace App\Repositories\DistrictPopulations;

use App\Repositories\BaseRepositoryInterface;

interface DistrictPopulationRepositoryInterface extends BaseRepositoryInterface
{
    public function getPopulationByDistrictsId(array $districtsId);
}
