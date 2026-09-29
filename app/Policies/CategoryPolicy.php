<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * View category list.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view categories');
    }

    /**
     * View a single category.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->can('view categories');
    }

    /**
     * Create category.
     */
    public function create(User $user): bool
    {
        return $user->can('create categories');
    }

    /**
     * Update category.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->can('edit categories');
    }

    /**
     * Delete category.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->can('delete categories');
    }

    /**
     * Restore category.
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->can('restore categories');
    }

    /**
     * Permanently delete category.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return $user->can('force delete categories');
    }
}