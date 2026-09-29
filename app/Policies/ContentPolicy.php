<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view contents');
    }

    public function view(User $user, Content $content): bool
    {
        return $user->can('view contents');
    }

    public function create(User $user): bool
    {
        return $user->can('create contents');
    }

    public function update(User $user, Content $content): bool
    {
        return $user->can('edit contents');
    }

    public function delete(User $user, Content $content): bool
    {
        return $user->can('delete contents');
    }

    public function restore(User $user, Content $content): bool
    {
        return $user->can('restore contents');
    }

    public function forceDelete(User $user, Content $content): bool
    {
        return $user->can('force delete contents');
    }
}
