<?php

namespace App\Repositories\Provinces;

use App\Repositories\Districts\District;
use App\Repositories\Entity;

/**
 * Class Province
 *
 * @property int           id
 * @property string        name
 * @property \DateTime     created_at
 * @property \DateTime     update_at
 *
 * @property-read District districts
 */
class Province extends Entity
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id', 'id');
    }
}
