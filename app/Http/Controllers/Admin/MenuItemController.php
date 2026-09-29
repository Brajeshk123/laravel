<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\StoreMenuItemRequest;
use App\Http\Requests\Menu\UpdateMenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\MenuService;

class MenuItemController extends Controller
{
    public function __construct(
        protected MenuService $menuService
    ) {}

    public function store(StoreMenuItemRequest $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $this->menuService->createItem($menu, $request->validated());

        return redirect()
            ->route('admin.menus.edit', $menu)
            ->with('success', 'Menu item added successfully.');
    }

    public function update(UpdateMenuItemRequest $request, Menu $menu, MenuItem $item)
    {
        $this->authorize('update', $menu);

        $this->menuService->updateItem($menu, $item, $request->validated());

        return redirect()
            ->route('admin.menus.edit', $menu)
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu, MenuItem $item)
    {
        $this->authorize('update', $menu);

        $this->menuService->deleteItem($menu, $item);

        return redirect()
            ->route('admin.menus.edit', $menu)
            ->with('success', 'Menu item deleted successfully.');
    }
}
