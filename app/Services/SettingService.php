<?php

namespace App\Services;

use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingService extends BaseService
{
    private const DEFINITIONS = [
        'general' => [
            'site_name' => ['type' => 'string', 'default' => ''],
            'site_description' => ['type' => 'text', 'default' => ''],
            'site_url' => ['type' => 'url', 'default' => ''],
            'admin_email' => ['type' => 'string', 'default' => ''],
            'logo' => ['type' => 'string', 'default' => ''],
            'favicon' => ['type' => 'string', 'default' => ''],
        ],
        'seo' => [
            'default_meta_title' => ['type' => 'string', 'default' => ''],
            'default_meta_description' => ['type' => 'text', 'default' => ''],
            'default_meta_keywords' => ['type' => 'string', 'default' => ''],
            'default_robots' => ['type' => 'string', 'default' => 'index, follow'],
            'default_og_image' => ['type' => 'url', 'default' => ''],
        ],
        'social' => [
            'facebook_url' => ['type' => 'url', 'default' => ''],
            'instagram_url' => ['type' => 'url', 'default' => ''],
            'linkedin_url' => ['type' => 'url', 'default' => ''],
            'youtube_url' => ['type' => 'url', 'default' => ''],
            'twitter_url' => ['type' => 'url', 'default' => ''],
        ],
        'system' => [
            'maintenance_mode' => ['type' => 'boolean', 'default' => '0'],
            'timezone' => ['type' => 'string', 'default' => 'UTC'],
            'posts_per_page' => ['type' => 'integer', 'default' => '10'],
        ],
    ];

    public function __construct(SettingRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function grouped(): array
    {
        $this->ensureDefaults();

        return $this->repository
            ->keyed()
            ->map(fn ($setting) => $setting->value)
            ->all();
    }

    public function updateSettings(array $data): void
    {
        DB::transaction(function () use ($data) {
            $settings = $this->repository->keyed();

            foreach (self::DEFINITIONS as $group => $definitions) {
                foreach ($definitions as $key => $definition) {
                    $value = $data[$key] ?? null;

                    if ($value instanceof UploadedFile) {
                        $value = $this->storeFile($key, $value, $settings->get($key)?->value);
                    } elseif (in_array($key, ['logo', 'favicon'], true) && ! array_key_exists($key, $data)) {
                        $value = $settings->get($key)?->value;
                    } elseif ($definition['type'] === 'boolean') {
                        $value = $value ? '1' : '0';
                    } elseif ($value === null) {
                        $value = '';
                    }

                    $this->repository->updateByKey($key, $value, $definition['type'], $group);
                }
            }
        });
    }

    public function definitions(): array
    {
        return self::DEFINITIONS;
    }

    private function ensureDefaults(): void
    {
        DB::transaction(function () {
            $settings = $this->repository->keyed();

            foreach (self::DEFINITIONS as $group => $definitions) {
                foreach ($definitions as $key => $definition) {
                    if (! $settings->has($key)) {
                        $this->repository->updateByKey(
                            $key,
                            $definition['default'],
                            $definition['type'],
                            $group
                        );
                    }
                }
            }
        });
    }

    private function storeFile(string $key, UploadedFile $file, ?string $oldPath): string
    {
        $path = $file->store('settings', 'public');

        if ($oldPath && str_starts_with($oldPath, 'settings/')) {
            Storage::disk('public')->delete($oldPath);
        }

        return $path;
    }
}
