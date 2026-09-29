<?php

namespace App\Repositories\Eloquent;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Repositories\Contracts\MenuRepositoryInterface;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    public function search(?string $search, int $perPage = 10)
    {
        return $this->model
            ->withCount('items')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findWithItems(int $id): Menu
    {
        return $this->model
            ->with([
                'items' => fn ($query) => $query
                    ->with(['content', 'category', 'parent'])
                    ->orderBy('parent_id')
                    ->orderBy('sort_order'),
            ])
            ->findOrFail($id);
    }

    public function createItem(Menu $menu, array $data): MenuItem
    {
        return $menu->items()->create($data);
    }

    public function updateItem(MenuItem $item, array $data): bool
    {
        return $item->update($data);
    }

    public function deleteItem(MenuItem $item): bool
    {
        return $item->delete();
    }
}
