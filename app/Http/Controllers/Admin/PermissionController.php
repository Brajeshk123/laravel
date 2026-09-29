<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $service
    ) {}

    public function index(Request $request)
    {
        $permissions = $this->service->paginate(
            15,
            $request->search
        );

        return view(
            'admin.permissions.index',
            compact('permissions')
        );
    }
}
