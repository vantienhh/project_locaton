<?php

namespace App\Repositories\DistrictPopulations;

use App\Repositories\BaseRepository;

class DistrictPopulationRepository extends BaseRepository implements DistrictPopulationRepositoryInterface
{
    public function __construct(DistrictPopulation $districtPopulation)
    {
        $this->setModel($districtPopulation);
    }

    /**
     * Lấy dân số của bản ghi gần nhất mỗi quận
     * @param array $districtsId
     * @return int
     */
    public function getPopulationByDistrictsId(array $districtsId)
    {
        $populations = $this->getModel()
            ->whereIn('district_id', $districtsId)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPopulation = 0;
        $groups = $populations->groupBy('district_id');

        foreach ($groups as $group) {
            if (count($group) > 1) {
                $totalPopulation += $group->sortByDesc('created_at')[0]->population;
            } else {
                $totalPopulation += $group[0]->population;
            }
        }

        return $totalPopulation;

    }

}
