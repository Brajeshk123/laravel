<?php

namespace App\Services;

use App\Models\Content;
use App\Models\Media;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MediaService
{
    public function __construct(
        protected MediaRepositoryInterface $repository
    ) {}

    public function paginate(?string $search = null, int $perPage = 12)
    {
        return $this->repository->paginate($perPage, $search);
    }

    public function find(int $id): Media
    {
        return $this->repository->find($id);
    }

    public function upload(UploadedFile $file, ?string $name, $user): Media
    {
        return DB::transaction(function () use ($file, $name, $user) {
            $path = $file->store('media', 'public');

            return $this->repository->create([
                'model_type' => $user::class,
                'model_id' => $user->id,
                'uuid' => (string) Str::uuid(),
                'collection_name' => 'media',
                'name' => $name ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_name' => $path,
                'mime_type' => $file->getMimeType(),
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => $file->getSize(),
                'manipulations' => [],
                'custom_properties' => [
                    'original_name' => $file->getClientOriginalName(),
                ],
                'generated_conversions' => [],
                'responsive_images' => [],
            ]);
        });
    }

    public function update(int $id, array $data): bool
    {
        $media = $this->repository->find($id);

        return $this->repository->update($media, [
            'name' => $data['name'],
        ]);
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $media = $this->repository->find($id);

            if (Content::where('featured_image', $media->file_name)->exists()) {
                throw ValidationException::withMessages([
                    'media' => 'This media file is currently used as a content featured image.',
                ]);
            }

            Storage::disk($media->disk)->delete($media->file_name);

            return $this->repository->delete($media);
        });
    }
}
