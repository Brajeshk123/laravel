<?php

namespace App\Repositories\Interfaces;

use App\Models\Media;

interface MediaRepositoryInterface
{
    public function paginate(int $perPage = 12, ?string $search = null);

    public function find(int $id): Media;

    public function create(array $data): Media;

    public function update(Media $media, array $data): bool;

    public function delete(Media $media): bool;
}
