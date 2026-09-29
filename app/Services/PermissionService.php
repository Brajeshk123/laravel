<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService
{
    public function __construct(
        protected PermissionRepositoryInterface $repository
    ){}

    public function paginate(
        $perPage=10,
        $search=null
    ){
        return $this->repository->paginate(
            $perPage,
            $search
        );
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id,array $data)
    {
        $permission=$this->repository->find($id);

        return $this->repository->update(
            $permission,
            $data
        );
    }

    public function delete($id)
    {
        $permission=$this->repository->find($id);

        return $this->repository->delete(
            $permission
        );
    }
}