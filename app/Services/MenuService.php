<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Repositories\Contracts\MenuRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MenuService extends BaseService
{
    public function __construct(MenuRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getMenus(?string $search = null)
    {
        return $this->repository->search($search);
    }

    public function findWithItems(int $id): Menu
    {
        return $this->repository->findWithItems($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);

            return parent::create($data);
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $id);

            return parent::update($id, $data);
        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            MenuItem::where('menu_id', $id)->update(['parent_id' => null]);
            MenuItem::where('menu_id', $id)->delete();

            return parent::delete($id);
        });
    }

    public function createItem(Menu $menu, array $data): MenuItem
    {
        return DB::transaction(function () use ($menu, $data) {
            $data = $this->normalizeItemData($data);
            $this->validateParentBelongsToMenu($menu, $data['parent_id'] ?? null);

            return $this->repository->createItem($menu, $data);
        });
    }

    public function updateItem(Menu $menu, MenuItem $item, array $data): bool
    {
        $this->ensureItemBelongsToMenu($menu, $item);

        return DB::transaction(function () use ($menu, $item, $data) {
            $data = $this->normalizeItemData($data);
            $this->validateParent($menu, $item, $data['parent_id'] ?? null);

            return $this->repository->updateItem($item, $data);
        });
    }

    public function deleteItem(Menu $menu, MenuItem $item): bool
    {
        $this->ensureItemBelongsToMenu($menu, $item);

        return DB::transaction(fn () => $this->repository->deleteItem($item));
    }

    private function normalizeItemData(array $data): array
    {
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['content_id'] = $data['type'] === 'content' ? $data['content_id'] : null;
        $data['category_id'] = $data['type'] === 'category' ? $data['category_id'] : null;
        $data['url'] = $data['type'] === 'custom_url' ? $data['url'] : null;
        $data['parent_id'] = $data['parent_id'] ?? null;

        return $data;
    }

    private function validateParent(Menu $menu, MenuItem $item, ?int $parentId): void
    {
        if ($parentId === null) {
            return;
        }

        if ($parentId === $item->id || $this->parentCreatesCycle($item, $parentId)) {
            throw ValidationException::withMessages([
                'parent_id' => 'The selected parent menu item is invalid.',
            ]);
        }

        if (! MenuItem::where('menu_id', $menu->id)->where('id', $parentId)->exists()) {
            throw ValidationException::withMessages([
                'parent_id' => 'The selected parent menu item must belong to this menu.',
            ]);
        }
    }

    private function validateParentBelongsToMenu(Menu $menu, ?int $parentId): void
    {
        if (
            $parentId !== null
            && ! MenuItem::where('menu_id', $menu->id)->where('id', $parentId)->exists()
        ) {
            throw ValidationException::withMessages([
                'parent_id' => 'The selected parent menu item must belong to this menu.',
            ]);
        }
    }

    private function parentCreatesCycle(MenuItem $item, int $parentId): bool
    {
        while ($parentId) {
            if ($parentId === $item->id) {
                return true;
            }

            $parentId = MenuItem::where('id', $parentId)->value('parent_id');
        }

        return false;
    }

    private function ensureItemBelongsToMenu(Menu $menu, MenuItem $item): void
    {
        if ($item->menu_id !== $menu->id) {
            abort(404);
        }
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Menu::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
