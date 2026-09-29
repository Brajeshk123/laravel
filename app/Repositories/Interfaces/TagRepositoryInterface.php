<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;

interface TagRepositoryInterface
{
    public function all();

    public function paginate(int $perPage = 10, ?string $search = null);

    public function find(int $id): Tag;

    public function create(array $data): Tag;

    public function update(Tag $tag, array $data): bool;

    public function delete(Tag $tag): bool;
}
