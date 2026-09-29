<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreContentRequest;
use App\Http\Requests\Content\UpdateContentRequest;
use App\Models\Category;
use App\Models\Content;
use App\Services\CategoryService;
use App\Services\ContentService;
use App\Services\TagService;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct(
        protected ContentService $contentService,
        protected CategoryService $categoryService,
        protected TagService $tagService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Content::class);

        $contents = $this->contentService->paginate(
            $request->only(['search', 'content_type', 'status', 'category_id'])
        );

        $categories = $this->categoryService->all();

        return view(
            'admin.contents.index',
            compact('contents', 'categories')
        );
    }

    public function create()
    {
        $this->authorize('create', Content::class);

        return view('admin.contents.create', $this->formData());
    }

    public function store(StoreContentRequest $request)
    {
        $this->authorize('create', Content::class);

        $data = $request->validated();
        $data['author_id'] = $request->user()->id;

        $this->contentService->create($data);

        return redirect()
            ->route('admin.contents.index')
            ->with('success', 'Content created successfully.');
    }

    public function edit(Content $content)
    {
        $this->authorize('update', $content);

        $content = $this->contentService->find($content->id);

        return view(
            'admin.contents.edit',
            array_merge($this->formData(), compact('content'))
        );
    }

    public function update(UpdateContentRequest $request, Content $content)
    {
        $this->authorize('update', $content);

        $this->contentService->update(
            $content->id,
            $request->validated()
        );

        return redirect()
            ->route('admin.contents.index')
            ->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        $this->authorize('delete', $content);

        $this->contentService->delete($content->id);

        return redirect()
            ->route('admin.contents.index')
            ->with('success', 'Content deleted successfully.');
    }

    private function formData(): array
    {
        return [
            'categories' => $this->categoryService->all(),
            'tags' => $this->tagService->all(),
            'contentTypes' => [
                'service' => 'Service',
                'blog' => 'Blog',
                'article' => 'Article',
            ],
            'statuses' => [
                'draft' => 'Draft',
                'published' => 'Published',
            ],
        ];
    }
}
