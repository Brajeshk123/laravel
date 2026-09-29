<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseCrudController extends Controller
{
    protected $service;
    protected string $viewPath;
    protected string $routeName;

    /**
     * List records
     */
    public function index(Request $request)
    {
        $data = $this->service->paginate();

        return view(
            "{$this->viewPath}.index",
            compact('data')
        );
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view("{$this->viewPath}.create");
    }

    /**
     * Store record
     */
    public function store(Request $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route("{$this->routeName}.index")
            ->with('success', 'Record created successfully.');
    }

    /**
     * Delete record
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()
            ->back()
            ->with('success', 'Record deleted successfully.');
    }
}