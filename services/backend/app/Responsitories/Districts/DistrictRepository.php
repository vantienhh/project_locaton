<?php

namespace App\Repositories\Districts;

use App\Repositories\BaseRepository;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    public function __construct(District $district)
    {
        $this->setModel($district);
    }

    public function getPopulationNearest($id)
    {
        $district = $this->getById($id);
        return $district->getPopulationNearest()->population;
    }
}
