<?php

namespace App\Repositories\DistrictPopulations;

use App\Repositories\Entity;

/**
 * Class DistrictPopulation
 *
 * @property int       id
 * @property int       district_id
 * @property int       population
 * @property \DateTime created_at
 * @property \DateTime update_at
 *
 */
class DistrictPopulation extends Entity
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['district_id', 'population'];

}
