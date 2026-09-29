<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Models\Content;
use App\Models\Tag;
use App\Repositories\Contracts\ContentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContentService
{
    public function __construct(
        protected ContentRepositoryInterface $repository
    ) {}

    public function paginate(array $filters = [], int $perPage = 10)
    {
        return $this->repository->paginateWithFilters($filters, $perPage);
    }

    public function find(int $id): Content
    {
        return $this->repository->findWithRelations($id);
    }

    public function create(array $data): Content
    {
        return DB::transaction(function () use ($data) {
            [$contentData, $categoryIds, $tagIds, $tagNames, $seoData] = $this->prepareData($data);

            $contentData['slug'] = $this->uniqueSlug(
                $contentData['slug'] ?? $contentData['title']
            );

            if (($contentData['status'] ?? 'draft') === 'published') {
                $contentData['published_at'] = now();
            }

            if (!empty($contentData['featured_image'])) {
                $contentData['featured_image'] = ImageHelper::upload(
                    $contentData['featured_image'],
                    'contents'
                );
            }

            $content = $this->repository->create($contentData);

            $this->syncRelations($content, $categoryIds, $tagIds, $tagNames);
            $this->syncSeo($content, $seoData);

            return $content;
        });
    }

    public function update(int $id, array $data): Content
    {
        return DB::transaction(function () use ($id, $data) {
            $content = $this->repository->findWithRelations($id);

            [$contentData, $categoryIds, $tagIds, $tagNames, $seoData] = $this->prepareData($data);

            if (!empty($contentData['slug'])) {
                $contentData['slug'] = $this->uniqueSlug($contentData['slug'], $content->id);
            } else {
                unset($contentData['slug']);
            }

            if (($contentData['status'] ?? $content->status) === 'published' && !$content->published_at) {
                $contentData['published_at'] = now();
            }

            if (($contentData['status'] ?? $content->status) === 'draft') {
                $contentData['published_at'] = null;
            }

            if (!empty($contentData['featured_image'])) {
                ImageHelper::delete($content->featured_image);

                $contentData['featured_image'] = ImageHelper::upload(
                    $contentData['featured_image'],
                    'contents'
                );
            }

            $content = $this->repository->update($content->id, $contentData);

            $this->syncRelations($content, $categoryIds, $tagIds, $tagNames);
            $this->syncSeo($content, $seoData);

            return $content;
        });
    }

    public function delete(int $id): bool
    {
        return (bool) $this->repository->delete($id);
    }

    private function prepareData(array $data): array
    {
        $categoryIds = $data['category_ids'] ?? [];
        $tagIds = $data['tags'] ?? [];
        $tagNames = $data['tag_names'] ?? null;
        $seoFields = [
            'meta_title',
            'meta_description',
            'meta_keywords',
            'canonical_url',
            'robots',
            'og_title',
            'og_description',
            'og_image',
            'twitter_card',
        ];

        $seoData = collect($data)
            ->only($seoFields)
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->all();

        unset(
            $data['category_ids'],
            $data['tags'],
            $data['tag_names'],
            $data['meta_title'],
            $data['meta_description'],
            $data['meta_keywords'],
            $data['canonical_url'],
            $data['robots'],
            $data['og_title'],
            $data['og_description'],
            $data['og_image'],
            $data['twitter_card']
        );

        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        $data['allow_comments'] = (bool) ($data['allow_comments'] ?? true);

        return [$data, $categoryIds, $tagIds, $tagNames, $seoData];
    }

    private function syncSeo(Content $content, array $seoData): void
    {
        $seoData = collect($seoData)
            ->map(fn ($value) => $value === '' ? null : $value)
            ->all();

        if (collect($seoData)->filter(fn ($value) => $value !== null)->isEmpty()) {
            return;
        }

        $content->seo()->updateOrCreate([], $seoData);
    }

    private function syncRelations(
        Content $content,
        array $categoryIds,
        array $tagIds,
        ?string $tagNames
    ): void {
        $content->categories()->sync($categoryIds);

        $tagIds = collect($tagIds)
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values();

        $newTagIds = collect(explode(',', (string) $tagNames))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->map(function ($name) {
                $slug = Str::slug($name);

                return Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                )->id;
            });

        $content->tags()->sync(
            $tagIds->merge($newTagIds)->unique()->values()->all()
        );
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Content::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
