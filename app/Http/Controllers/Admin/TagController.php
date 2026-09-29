<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(
        protected TagService $service
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Tag::class);

        $tags = $this->service->paginate($request->search);

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        $this->authorize('create', Tag::class);

        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $this->authorize('create', Tag::class);

        $this->service->create($request->validated());

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);

        return view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $this->service->update($tag->id, $request->validated());

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        $this->service->delete($tag->id);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
}
