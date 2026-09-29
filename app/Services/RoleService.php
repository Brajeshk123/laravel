<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleService
{
    public function __construct(
        protected RoleRepositoryInterface $repository
    ) {}

    public function paginate($perPage = 10, $search = null)
    {
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
        return DB::transaction(function () use ($data) {
            $role = $this->repository->create($data);

            $this->forgetPermissionCache();

            return $role;
        });
    }

    public function update($id, array $data)
    {
        $role = $this->repository->find($id);

        if ($role->name === 'Super Admin' && $data['name'] !== 'Super Admin') {
            throw new \InvalidArgumentException('The Super Admin role name cannot be changed.');
        }

        return DB::transaction(function () use ($role, $data) {
            $updated = $this->repository->update(
                $role,
                $data
            );

            $this->forgetPermissionCache();

            return $updated;
        });
    }

    public function delete($id)
    {
        $role = $this->repository->find($id);

        if ($role->name === 'Super Admin') {
            throw new \InvalidArgumentException('The Super Admin role cannot be deleted.');
        }

        return DB::transaction(function () use ($role) {
            $deleted = $this->repository->delete($role);

            $this->forgetPermissionCache();

            return $deleted;
        });
    }

    public function syncPermissions($id, array $permissionIds): void
    {
        $role = $this->repository->find($id);

        DB::transaction(function () use ($role, $permissionIds) {
            $permissions = Permission::whereIn('id', $permissionIds)
                ->where('guard_name', $role->guard_name)
                ->get();

            $role->syncPermissions($permissions);

            $this->forgetPermissionCache();
        });
    }

    private function forgetPermissionCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
