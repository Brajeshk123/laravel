<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function __construct(
        protected RoleService $service
    ) {}

    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $role->load('permissions');

        $permissions = Permission::orderBy('name')
                        ->get()
                        ->groupBy(function ($permission) {
                            // Group by first word, e.g. "view users" → "Users"
                            $parts = explode(' ', $permission->name);
                            return ucfirst($parts[1] ?? $parts[0]);
                        });

        return view(
            'admin.roles.permissions',
            compact('role', 'permissions')
        );
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $data = $request->validate([
            'permissions' => [
                'nullable',
                'array',
            ],
            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],
        ]);

        $this->service->syncPermissions(
            $role->id,
            $data['permissions'] ?? []
        );

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'Permissions updated successfully.'
            );
    }
}
