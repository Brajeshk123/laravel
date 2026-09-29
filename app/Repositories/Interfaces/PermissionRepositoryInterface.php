<?php

namespace App\Repositories\Interfaces;

use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    public function paginate(
        int $perPage = 10,
        ?string $search = null
    );

    public function all();

    public function find(int $id): Permission;

    public function create(array $data): Permission;

    public function update(
        Permission $permission,
        array $data
    ): bool;

    public function delete(
        Permission $permission
    ): bool;
}