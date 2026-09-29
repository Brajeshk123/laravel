<?php

namespace App\Repositories\Contracts;

use App\Models\Content;

interface ContentRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateWithFilters(array $filters = [], int $perPage = 10);

    public function findWithRelations(int $id): Content;
}
