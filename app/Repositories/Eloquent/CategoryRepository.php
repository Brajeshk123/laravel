<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function search(?string $search, int $perPage = 10)
    {
        return $this->model
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->with('parent')
            ->orderBy('sort_order')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getTrashed()
    {
        return $this->model
            ->onlyTrashed()
            ->with('parent')
            ->latest('deleted_at')
            ->paginate(10);
    }

    public function restore(int $id)
    {
        $category = $this->model
            ->onlyTrashed()
            ->findOrFail($id);

        $category->restore();

        return $category;
    }

    public function forceDelete(int $id)
    {
        $category = $this->model
            ->onlyTrashed()
            ->findOrFail($id);

        return $category->forceDelete();
    }

    public function getTrashedCount()
    {
        return $this->model->onlyTrashed()->count();
    }
}