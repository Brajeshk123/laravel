<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionGeneratorController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('create permissions'), 403);

        return view('admin.permissions.generator');
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->can('create permissions'), 403);

        $request->validate([
            'module' => 'required|string|max:100',
        ]);

        $module = Str::lower($request->module);

        $actions = [
            'view',
            'create',
            'edit',
            'delete',
        ];

        foreach ($actions as $action) {

            Permission::firstOrCreate(
                [
                    'name'       => "{$action} {$module}",
                    'guard_name' => 'web',
                ]
            );

        }

        return back()->with(
            'success',
            'Permissions generated successfully.'
        );
    }
}
