<?php

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    public function __construct(
        protected Tag $model
    ) {}

    public function all()
    {
        return $this->model->orderBy('name')->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null)
    {
        return $this->model
            ->withCount('contents')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id): Tag
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Tag
    {
        return $this->model->create($data);
    }

    public function update(Tag $tag, array $data): bool
    {
        return $tag->update($data);
    }

    public function delete(Tag $tag): bool
    {
        return $tag->delete();
    }
}
