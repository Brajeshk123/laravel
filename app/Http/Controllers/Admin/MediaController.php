<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Requests\Media\UpdateMediaRequest;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $service
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Media::class);

        $media = $this->service->paginate($request->search);

        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        $this->authorize('create', Media::class);

        return view('admin.media.create');
    }

    public function store(StoreMediaRequest $request)
    {
        $this->authorize('create', Media::class);

        $this->service->upload(
            $request->file('image'),
            $request->input('name'),
            $request->user()
        );

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    public function edit(Media $medium)
    {
        $this->authorize('update', $medium);

        return view('admin.media.edit', [
            'media' => $medium,
        ]);
    }

    public function update(UpdateMediaRequest $request, Media $medium)
    {
        $this->authorize('update', $medium);

        $this->service->update($medium->id, $request->validated());

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $medium)
    {
        $this->authorize('delete', $medium);

        $this->service->delete($medium->id);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media deleted successfully.');
    }
}
