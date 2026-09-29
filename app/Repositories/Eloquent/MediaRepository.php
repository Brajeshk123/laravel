<?php

namespace App\Repositories\Eloquent;

use App\Models\Media;
use App\Repositories\Interfaces\MediaRepositoryInterface;

class MediaRepository implements MediaRepositoryInterface
{
    public function __construct(
        protected Media $model
    ) {}

    public function paginate(int $perPage = 12, ?string $search = null)
    {
        return $this->model
            ->with('model')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%")
                    ->orWhere('mime_type', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id): Media
    {
        return $this->model->with('model')->findOrFail($id);
    }

    public function create(array $data): Media
    {
        return $this->model->create($data);
    }

    public function update(Media $media, array $data): bool
    {
        return $media->update($data);
    }

    public function delete(Media $media): bool
    {
        return $media->delete();
    }
}
