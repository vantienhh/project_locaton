<?php

namespace App\Repositories\Provinces;

use App\Repositories\BaseRepository;
use App\Repositories\DistrictPopulations\DistrictPopulationRepositoryInterface;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    public function __construct(Province $province)
    {
        $this->setModel($province);
    }

    public function getProvincePopulationNearest(int $id)
    {
        $province = $this->getById($id);

        $districtsId            = $province->districts->pluck('id')->toArray();
        $districtPopulationRepo = app()->make(DistrictPopulationRepositoryInterface::class);

        return $districtPopulationRepo->getPopulationByDistrictsId($districtsId);
    }

}
