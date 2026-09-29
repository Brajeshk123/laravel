<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function paginate(
        int $perPage = 10,
        ?string $search = null
    ) {
        return Role::when($search, function ($query) use ($search) {

                $query->where('name', 'like', "%{$search}%");

            })
            ->withCount('permissions')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function all()
    {
        return Role::orderBy('name')->get();
    }

    public function find(int $id): Role
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function create(array $data): Role
    {
        $data['guard_name'] = $data['guard_name'] ?? 'web';

        return Role::create($data);
    }

    public function update(Role $role, array $data): bool
    {
        return $role->update($data);
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}
