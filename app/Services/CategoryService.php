<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService extends BaseService
{
    public function __construct(CategoryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Search categories
     */
    public function getCategories(?string $search = null)
    {
        return $this->repository->search($search);
    }

    /**
     * Business Logic
     */
    public function create(array $data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Check slug uniqueness (including soft-deleted records)
        if (Category::withTrashed()->where('slug', $data['slug'])->exists()) {
            throw ValidationException::withMessages([
                'name' => 'A category with this name already exists (slug "' . $data['slug'] . '" is taken).',
                'slug' => 'The slug "' . $data['slug'] . '" already exists. Please provide a unique slug.',
            ]);
        }

        return parent::create($data);
    }

    /**
     * Business Logic
     */
    public function update(int $id, array $data)
    {
        $this->validateParent($id, $data['parent_id'] ?? null);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Check slug uniqueness (including soft-deleted records, exclude current)
        if (Category::withTrashed()->where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
            throw ValidationException::withMessages([
                'slug' => 'The slug "' . $data['slug'] . '" already exists. Please provide a unique slug.',
            ]);
        }

        return parent::update($id, $data);
    }

    private function validateParent(int $id, ?int $parentId): void
    {
        if ($parentId === null) {
            return;
        }

        if ($parentId === $id || $this->parentCreatesCycle($id, $parentId)) {
            throw ValidationException::withMessages([
                'parent_id' => 'The selected parent category is invalid.',
            ]);
        }
    }

    private function parentCreatesCycle(int $id, int $parentId): bool
    {
        while ($parentId) {
            if ($parentId === $id) {
                return true;
            }

            $parentId = Category::where('id', $parentId)->value('parent_id');
        }

        return false;
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
    public function getTrashed()
    {
        return $this->repository->getTrashed();
    }

    public function restore(int $id)
    {
        return $this->repository->restore($id);
    }

    public function forceDelete(int $id)
    {
        return $this->repository->forceDelete($id);
    }

    public function getTrashedCount()
    {
        return $this->repository->getTrashedCount();
    }
}
