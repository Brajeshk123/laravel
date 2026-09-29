<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $roles = $this->service->paginate(
            10,
            $request->search
        );

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('create', Role::class);

        return view('admin.roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $this->service->store($request->validated());

        return redirect()
            ->route('admin.roles.index')
            ->with('success','Role created successfully.');
    }

    public function edit($id)
    {
        $role = $this->service->find($id);

        $this->authorize('update', $role);

        return view('admin.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request,$id)
    {
        $role = $this->service->find($id);

        $this->authorize('update', $role);

        try {
            $this->service->update(
                $id,
                $request->validated()
            );
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success','Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = $this->service->find($id);

        $this->authorize('delete', $role);

        try {
            $this->service->delete($id);
        } catch (\InvalidArgumentException $e) {
            return back()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success','Role deleted successfully.');
    }
}
