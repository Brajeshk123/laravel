<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function paginate(
        int $perPage = 10,
        ?string $search = null
    ) {
        return Permission::with('roles')
            ->when($search, function ($query) use ($search) {

                $query->where('name', 'LIKE', "%{$search}%");

            })
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function all()
    {
        return Permission::all();
    }

    public function find(int $id): Permission
    {
        return Permission::findOrFail($id);
    }

    public function create(array $data): Permission
    {
        return Permission::create($data);
    }

    public function update(
        Permission $permission,
        array $data
    ): bool {
        return $permission->update($data);
    }

    public function delete(
        Permission $permission
    ): bool {
        return $permission->delete();
    }
}
