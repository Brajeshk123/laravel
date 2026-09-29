<?php

namespace App\Repositories\Contracts;

use App\Models\Menu;
use App\Models\MenuItem;

interface MenuRepositoryInterface extends BaseRepositoryInterface
{
    public function search(?string $search, int $perPage = 10);

    public function findWithItems(int $id): Menu;

    public function createItem(Menu $menu, array $data): MenuItem;

    public function updateItem(MenuItem $item, array $data): bool;

    public function deleteItem(MenuItem $item): bool;
}
