<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\ProvinceTransformer;
use App\Repositories\Provinces\ProvinceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProvinceController extends ApiController
{
    private ProvinceRepositoryInterface $province;

    public function __construct(ProvinceRepositoryInterface $province)
    {
        $this->province = $province;
        $this->setTransformer(new ProvinceTransformer());
    }

    public function index(Request $request)
    {
        $limit = $request->get('limit', 20);
        $data = $this->province->getByQuery($request->all(), $limit);
        
        return $this->successResponse($data);
    }

    public function getProvincePopulation(Request $request)
    {
        try {
            $this->setTransformer(false);

            if ($provinceId = $request->get('province_id', null)) {
                $population = $this->province->getProvincePopulationNearest($provinceId);
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
