<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = $this->service->paginate(
            10,
            $request->search
        );

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $roles = Role::orderBy('name')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $this->service->store(
            $request->validated()
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->service->find($id);

        $this->authorize('update', $user);

        $roles = Role::orderBy('name')->get();

        return view(
            'admin.users.edit',
            compact('user', 'roles')
        );
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->service->find($id);

        $this->authorize('update', $user);

        $this->service->update(
            $id,
            $request->validated()
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = $this->service->find($id);

        $this->authorize('delete', $user);

        $this->service->delete($id);

        return back()
            ->with('success', 'User deleted successfully.');
    }
}
