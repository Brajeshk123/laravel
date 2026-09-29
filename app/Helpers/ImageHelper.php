<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function upload(
        UploadedFile $file,
        string $folder
    ): string
    {

        return $file->store(
            $folder,
            'public'
        );

    }

    public static function delete(?string $path): void
    {
        if($path && Storage::disk('public')->exists($path))
        {
            Storage::disk('public')->delete($path);
        }
    }
}