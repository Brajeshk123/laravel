<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagService
{
    public function __construct(
        protected TagRepositoryInterface $repository
    ) {}

    public function all()
    {
        return $this->repository->all();
    }

    public function paginate(?string $search = null, int $perPage = 10)
    {
        return $this->repository->paginate($perPage, $search);
    }

    public function find(int $id): Tag
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Tag
    {
        return DB::transaction(function () use ($data) {
            $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);

            return $this->repository->create($data);
        });
    }

    public function update(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            $tag = $this->repository->find($id);
            $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $tag->id);

            return $this->repository->update($tag, $data);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $tag = $this->repository->find($id);

            return $this->repository->delete($tag);
        });
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Tag::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
