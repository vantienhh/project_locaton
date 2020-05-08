<?php

namespace App\Repositories\Districts;

use App\Repositories\DistrictPopulations\DistrictPopulation;
use App\Repositories\Entity;

/**
 * Class District
 *
 * @property int                     id
 * @property string                  name
 * @property string                  province_id
 * @property \DateTime               created_at
 * @property \DateTime               update_at
 *
 * @property-read DistrictPopulation populations
 *
 */
class District extends Entity
{
    use FilterTrait, PresentationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'province_id'];

    public function populations()
    {
        return $this->hasMany(DistrictPopulation::class, 'district_id', 'id');
    }

}
