<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->latest()->get();
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->find($id);

        $record->update($data);

        return $record;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function findBy(string $column, $value)
    {
        return $this->model
            ->where($column, $value)
            ->first();
    }

    public function count()
    {
        return $this->model->count();
    }

    public function exists(int $id)
    {
        return $this->model
            ->where('id', $id)
            ->exists();
    }
}