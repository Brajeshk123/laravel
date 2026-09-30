<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Content;
use App\Models\Menu;
use App\Services\SettingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function home()
    {
        $featuredContent = $this->contentTableExists()
            ? $this->publishedContentQuery()
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(4)
                ->get()
            : collect();

        $featuredServices = $this->contentTableExists()
            ? $this->publishedContentQuery('service')
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(3)
                ->get()
            : collect();

        if ($featuredServices->isEmpty() && $this->contentTableExists()) {
            $featuredServices = $this->publishedContentQuery('service')
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        $latestPosts = $this->contentTableExists()
            ? $this->publishedContentQuery('blog')
                ->latest('published_at')
                ->take(3)
                ->get()
            : collect();

        return $this->frontendView('frontend.pages.home', compact('featuredContent', 'featuredServices', 'latestPosts'));
    }

    public function services()
    {
        $services = $this->contentTableExists()
            ? $this->publishedContentQuery('service')
                ->latest('published_at')
                ->paginate($this->postsPerPage())
                ->withQueryString()
            : $this->emptyPaginator();

        return $this->frontendView('frontend.pages.services.index', compact('services'), [
            'title' => 'Services',
        ]);
    }

    public function serviceShow(string $slug)
    {
        abort_unless($this->contentTableExists(), 404);

        $content = $this->publishedContentQuery('service')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedServices = $this->relatedContent($content, 'service', 3);

        return $this->frontendView('frontend.pages.services.show', compact('content', 'relatedServices'), $this->contentSeo($content));
    }

    public function blog(Request $request)
    {
        $query = trim((string) $request->query('q'));
        $category = trim((string) $request->query('category'));

        $posts = $this->contentTableExists()
            ? $this->publishedContentQuery('blog')
                ->when($query !== '', function (Builder $builder) use ($query) {
                    $builder->where(function (Builder $builder) use ($query) {
                        $builder->where('title', 'like', "%{$query}%")
                            ->orWhere('excerpt', 'like', "%{$query}%");
                    });
                })
                ->when($category !== '', function (Builder $builder) use ($category) {
                    $builder->whereHas('categories', function (Builder $builder) use ($category) {
                        $builder->where('slug', $category)
                            ->where('status', true);
                    });
                })
                ->latest('published_at')
                ->paginate($this->postsPerPage())
                ->withQueryString()
            : $this->emptyPaginator();

        $featuredPost = $this->contentTableExists()
            ? $this->publishedContentQuery('blog')
                ->where('is_featured', true)
                ->latest('published_at')
                ->first()
            : null;

        $categories = $this->activeCategories();

        return $this->frontendView('frontend.pages.blog.index', compact('posts', 'featuredPost', 'categories', 'query', 'category'), [
            'title' => 'Blog',
        ]);
    }

    public function blogShow(string $slug)
    {
        abort_unless($this->contentTableExists(), 404);

        $content = $this->publishedContentQuery()
            ->whereIn('content_type', ['blog', 'article'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = $this->relatedContent($content, $content->content_type, 3);
        $previousPost = $this->adjacentContent($content, $content->content_type, 'previous');
        $nextPost = $this->adjacentContent($content, $content->content_type, 'next');

        return $this->frontendView(
            'frontend.pages.blog.show',
            compact('content', 'relatedPosts', 'previousPost', 'nextPost'),
            $this->contentSeo($content)
        );
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->query('q'));
        $category = trim((string) $request->query('category'));

        $contents = $this->contentTableExists()
            ? $this->publishedContentQuery()
                ->when($query !== '', function (Builder $builder) use ($query) {
                    $builder->where(function (Builder $builder) use ($query) {
                        $builder->where('title', 'like', "%{$query}%")
                            ->orWhere('excerpt', 'like', "%{$query}%");
                    });
                })
                ->when($category !== '', function (Builder $builder) use ($category) {
                    $builder->whereHas('categories', function (Builder $builder) use ($category) {
                        $builder->where('slug', $category)
                            ->where('status', true);
                    });
                })
                ->latest('published_at')
                ->paginate($this->postsPerPage())
                ->withQueryString()
            : $this->emptyPaginator();

        return $this->frontendView('frontend.pages.search', compact('contents', 'query', 'category'), [
            'title' => 'Search',
        ]);
    }

    public function contact()
    {
        return $this->frontendView('frontend.pages.contact', [], [
            'title' => 'Contact',
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        ContactUs::create(array_merge($validated, [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]));

        return back()
            ->with('status', 'Thanks, your message has been sent successfully.');
    }

    private function frontendView(string $view, array $data = [], array $seo = [])
    {
        $settings = $this->settings();

        return view($view, array_merge($data, [
            'settings' => $settings,
            'navigation' => $this->navigation(),
            'seo' => $this->seoDefaults($settings, $seo),
        ]));
    }

    private function publishedContentQuery(?string $type = null): Builder
    {
        return Content::query()
            ->with(['categories', 'tags', 'seo'])
            ->where('status', 'published')
            ->where(function (Builder $query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->when($type, fn (Builder $query) => $query->where('content_type', $type));
    }

    private function relatedContent(Content $content, string $type, int $limit): Collection
    {
        $categoryIds = $content->categories->pluck('id');

        return $this->publishedContentQuery($type)
            ->whereKeyNot($content->id)
            ->when($categoryIds->isNotEmpty(), function (Builder $builder) use ($categoryIds) {
                $builder->whereHas('categories', fn (Builder $query) => $query->whereIn('categories.id', $categoryIds));
            })
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    private function adjacentContent(Content $content, string $type, string $direction): ?Content
    {
        $operator = $direction === 'previous' ? '<' : '>';
        $order = $direction === 'previous' ? 'desc' : 'asc';
        $publishedAt = $content->published_at ?? $content->created_at;

        return $this->publishedContentQuery($type)
            ->whereKeyNot($content->id)
            ->where(function (Builder $builder) use ($operator, $publishedAt) {
                $builder->where('published_at', $operator, $publishedAt)
                    ->orWhere(function (Builder $builder) use ($operator, $publishedAt) {
                        $builder->whereNull('published_at')
                            ->where('created_at', $operator, $publishedAt);
                    });
            })
            ->orderBy('published_at', $order)
            ->first();
    }

    private function activeCategories(): Collection
    {
        if (! Schema::hasTable('categories')) {
            return collect();
        }

        return Category::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    private function navigation()
    {
        if (! Schema::hasTable('menus') || ! Schema::hasTable('menu_items')) {
            return collect();
        }

        $menu = Menu::query()
            ->with([
                'items' => function ($query) {
                    $query->where('status', true)
                        ->with([
                            'content' => fn ($query) => $query->where('status', 'published'),
                            'category' => fn ($query) => $query->where('status', true),
                            'children' => fn ($query) => $query->where('status', true)->orderBy('sort_order'),
                            'children.content' => fn ($query) => $query->where('status', 'published'),
                            'children.category' => fn ($query) => $query->where('status', true),
                        ])
                        ->orderBy('sort_order');
                },
            ])
            ->where('status', true)
            ->orderByRaw("CASE WHEN slug = 'main-menu' THEN 0 ELSE 1 END")
            ->orderBy('id')
            ->first();

        return $menu
            ? $menu->items->whereNull('parent_id')->values()
            : collect();
    }

    private function seoDefaults(array $settings, array $seo = []): array
    {
        $siteName = $settings['site_name'] ?? config('app.name');
        $siteDescription = $settings['site_description'] ?? '';
        $defaultMetaTitle = $settings['default_meta_title'] ?? '';
        $defaultMetaDescription = $settings['default_meta_description'] ?? '';
        $defaultRobots = $settings['default_robots'] ?? '';

        return array_merge([
            'title' => $defaultMetaTitle ?: $siteName,
            'description' => $defaultMetaDescription ?: $siteDescription,
            'keywords' => $settings['default_meta_keywords'] ?? '',
            'canonical' => url()->current(),
            'robots' => $defaultRobots ?: 'index, follow',
            'og_title' => $defaultMetaTitle ?: $siteName,
            'og_description' => $defaultMetaDescription ?: $siteDescription,
            'og_image' => $settings['default_og_image'] ?? '',
            'twitter_card' => 'summary_large_image',
        ], array_filter($seo, fn ($value) => $value !== null && $value !== ''));
    }

    private function contentSeo(Content $content): array
    {
        $seo = $content->seo;

        return [
            'title' => $seo?->meta_title ?: $content->title,
            'description' => $seo?->meta_description ?: $content->excerpt,
            'keywords' => $seo?->meta_keywords,
            'canonical' => $seo?->canonical_url ?: url()->current(),
            'robots' => $seo?->robots,
            'og_title' => $seo?->og_title ?: $content->title,
            'og_description' => $seo?->og_description ?: $content->excerpt,
            'og_image' => $seo?->og_image ?: $content->featured_image,
            'twitter_card' => $seo?->twitter_card,
        ];
    }

    private function postsPerPage(): int
    {
        $settings = $this->settings();

        return max(1, min(100, (int) ($settings['posts_per_page'] ?? 10)));
    }

    private function settings(): array
    {
        if (! Schema::hasTable('settings')) {
            return [];
        }

        return $this->settingService->grouped();
    }

    private function contentTableExists(): bool
    {
        return Schema::hasTable('contents');
    }

    private function emptyPaginator(): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            new Collection(),
            0,
            $this->postsPerPage(),
            LengthAwarePaginator::resolveCurrentPage(),
            ['path' => request()->url()]
        );
    }
}
