<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\DistrictTransformer;
use App\Repositories\Districts\DistrictRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DistrictController extends ApiController
{
    private DistrictRepositoryInterface $district;

    public function __construct(DistrictRepositoryInterface $district)
    {
        $this->district = $district;
        $this->setTransformer(new DistrictTransformer());
    }

    public function index(Request $request)
    {
        if ($provinceId = $request->get('province_id', null)) {
            $data = $this->district->getByQuery($request->query(), 20);
            return $this->successResponse($data);
        }

        $this->setTransformer(false);
        return $this->successResponse([]);
    }

    public function getDistrictPopulation(Request $request)
    {
        try {
            $this->setTransformer(false);

            if ($districtId = $request->get('district_id', null)) {
                $population = $this->district->getPopulationNearest($districtId);

                return $this->successResponse([
                    'population' => $population
                ]);
            }

            return $this->successResponse([]);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        } catch (\Throwable $t) {
            throw $t;
        }
    }

}
