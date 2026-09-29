<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Content;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(
        protected MenuService $menuService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Menu::class);

        $menus = $this->menuService->getMenus($request->search);

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $this->authorize('create', Menu::class);

        return view('admin.menus.create');
    }

    public function store(StoreMenuRequest $request)
    {
        $this->authorize('create', Menu::class);

        $menu = $this->menuService->create($request->validated());

        return redirect()
            ->route('admin.menus.edit', $menu)
            ->with('success', 'Menu created successfully.');
    }

    public function show(Menu $menu)
    {
        return redirect()->route('admin.menus.edit', $menu);
    }

    public function edit(Menu $menu)
    {
        $this->authorize('update', $menu);

        $menu = $this->menuService->findWithItems($menu->id);
        $contents = Content::orderBy('title')->get(['id', 'title']);
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('admin.menus.edit', compact('menu', 'contents', 'categories'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $this->menuService->update($menu->id, $request->validated());

        return redirect()
            ->route('admin.menus.edit', $menu)
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $this->authorize('delete', $menu);

        $this->menuService->delete($menu->id);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }
}
