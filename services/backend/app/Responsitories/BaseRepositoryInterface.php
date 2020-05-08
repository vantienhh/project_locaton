<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function setModel($model);

    public function getModel();

    public function getById($id);

    public function getByIdInTrash($id);

    public function getByQuery(array $params = [], $limit = 20);

    public function store(array $params);

    public function storeArray(array $params);

    public function update($id, array $params, array $expect = [], array $onnly = []);

    public function delete($id);

    public function destroy($id);

    public function restore($id);

}
