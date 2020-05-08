<?php

namespace App\Repositories;

use Illuminate\Support\Arr;

abstract class BaseRepository implements BaseRepositoryInterface
{
    private $model;

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * Lấy thông tin 1 bản ghi xác định bởi ID
     * @return mixed
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Lấy thông tin bản ghi đã bị xóa softDelete bởi ID
     * @param $id
     * @return mixed
     */
    public function getByIdInTrash($id)
    {
        return $this->getModel()->withTrashed()->findOrFail($id);
    }

    public function getByQuery(array $params = [], $size = 20)
    {
        $sort = Arr::get($params, 'sort', 'created_at:-1');
        $params['sort'] = $sort;
        $lModel = $this->getModel();
        $params = Arr::except($params, ['page', 'limit']);
        if (count($params)) {
            $reflection = new \ReflectionClass($lModel);
            foreach ($params as $funcName => $funcParams) {
                $funcName = \Illuminate\Support\Str::studly($funcName);
                if ($reflection->hasMethod('scope' . $funcName)) {
                    $funcName = lcfirst($funcName);
                    $lModel = $lModel->$funcName($funcParams);
                }
            }
        }
        switch ($size) {
            case -1:
                return $lModel->get();
                break;
            case 0:
                return $lModel->first();
            default:
                return $lModel->paginate($size);
                break;
        }
    }

    public function store(array $data)
    {
        return $this->getModel()->create(Arr::only($data, $this->getModel()->getFillable()));
    }

    public function storeArray(array $datas)
    {
        if (count($datas) && is_array(reset($datas))) {
            $fillable = $this->getModel()->getFillable();
            $now = \Carbon\Carbon::now();

            foreach ($datas as $key => $data) {
                $datas[$key] = Arr::only($data, $fillable);
                if ($this->getModel()->usesTimestamps()) {
                    $datas[$key]['created_at'] = $now;
                    $datas[$key]['updated_at'] = $now;
                }
            }
            return $this->getModel()->insert($datas);
        }

        return $this->store($datas);
    }

    public function update($id, array $data, array $expect = [], array $only = [])
    {
        $record = $this->getById($id);

        $data = Arr::except($data, $expect);
        if (count($only)) {
            $data = Arr::only($data, $only);
        }

        $record->fill($data)->save();
        return $record;
    }

    /**
     * Xóa 1 bản ghi.
     * Nếu model có softDelete thì đưa bản ghi vào trash
     *
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function delete($id)
    {
        $record = $this->getById($id);
        return $record->delete();
    }

    /**
     * Xóa hoàn toàn một bản ghi
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        $record = $this->getById($id);
        return $record->forceDelete();
    }

    public function restore($id)
    {
        $record = $this->getById($id);
        return $record->restore();
    }
}
