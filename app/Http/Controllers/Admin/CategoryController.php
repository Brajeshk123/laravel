<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Display category listing
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Category::class);

        $categories = $this->categoryService->getCategories(
            $request->search
        );

        $trashCount = $this->categoryService->getTrashedCount();

        return view(
            'admin.categories.index',
            compact('categories', 'trashCount')
        );
    }

    /**
     * Show create form
     */
    public function create()
    {
        $this->authorize('create', Category::class);

        $parents = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.create',
            compact('parents')
        );
    }

    /**
     * Store category
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.edit',
            compact('category', 'parents')
        );
    }

    /**
     * Update category
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ) {
        $this->authorize('update', $category);

        $this->categoryService->update(
            $category->id,
            $request->validated()
        );

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Delete category
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $this->categoryService->delete($category->id);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category moved to trash.');
    }

    public function trash()
    {
        abort_unless(
            auth()->user()->can('delete categories')
                || auth()->user()->can('restore categories')
                || auth()->user()->can('force delete categories'),
            403
        );

        $categories = $this->categoryService->getTrashed();

        return view(
            'admin.categories.trash',
            compact('categories')
        );
    }

    public function restore(int $id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        $this->authorize('restore', $category);

        $this->categoryService->restore($category->id);

        return redirect()
            ->route('admin.categories.trash')
            ->with('success', 'Category restored successfully.');
    }

    public function forceDelete(int $id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $category);

        $this->categoryService->forceDelete($category->id);

        return redirect()
            ->route('admin.categories.trash')
            ->with('success', 'Category permanently deleted.');
    }
}
