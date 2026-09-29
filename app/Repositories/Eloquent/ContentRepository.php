<?php

namespace App\Repositories\Eloquent;

use App\Models\Content;
use App\Repositories\Contracts\ContentRepositoryInterface;

class ContentRepository extends BaseRepository implements ContentRepositoryInterface
{
    public function __construct(Content $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 10)
    {
        return $this->model
            ->with(['author', 'categories', 'tags', 'seo'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%");
                });
            })
            ->when($filters['content_type'] ?? null, function ($query, $type) {
                $query->where('content_type', $type);
            })
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['category_id'] ?? null, function ($query, $categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findWithRelations(int $id): Content
    {
        return $this->model
            ->with(['author', 'categories', 'tags', 'seo'])
            ->findOrFail($id);
    }
}
