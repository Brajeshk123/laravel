<?php

namespace App\Repositories\Interfaces;

use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function paginate(
        int $perPage = 10,
        ?string $search = null
    );

    public function all();

    public function find(int $id): Role;

    public function create(array $data): Role;

    public function update(Role $role, array $data): bool;

    public function delete(Role $role): bool;
}