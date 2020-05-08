<?php

namespace App\Repositories\Districts;

use App\Repositories\DistrictPopulations\DistrictPopulation;

trait PresentationTrait
{
    public function getPopulationNearest(): DistrictPopulation
    {
        return $this->populations()
                ->orderBy('created_at', 'DESC')->first();
    }
}
