<?php

namespace App\Support;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Files uploaded through the CMS live on the "uploads" disk (Neon Object Storage).
 * Content seeded before the CMS existed points at files bundled in public/ (e.g. "images/partners/teta.png");
 * those keep working and are never deleted from here.
 */
class Uploads
{
    public const DISK = 'uploads';

    /**
     * Store an uploaded file under the given folder with a unique, unguessable name.
     *
     * @return string the stored path, saved on the content record
     */
    public static function store(UploadedFile $file, string $folder): string
    {
        $name = Str::uuid7().'.'.strtolower($file->extension() ?: $file->getClientOriginalExtension());

        return self::disk()->putFileAs($folder, $file, $name, [
            'ContentType' => $file->getMimeType(),
            'CacheControl' => 'public, max-age=31536000, immutable',
        ]);
    }

    /**
     * Public URL for a stored path, whether uploaded through the CMS or bundled with the site.
     */
    public static function url(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return self::isBundled($path) ? asset($path) : self::disk()->url($path);
    }

    /**
     * Delete a CMS upload. Bundled site files and external links are left alone.
     */
    public static function delete(?string $path): void
    {
        if ($path === null || $path === '' || self::isBundled($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        self::disk()->delete($path);
    }

    /**
     * Swap a record's file: store the new upload and remove the old one once the new one is safely stored.
     */
    public static function replace(?UploadedFile $file, ?string $currentPath, string $folder): ?string
    {
        if ($file === null) {
            return $currentPath;
        }

        $path = self::store($file, $folder);
        self::delete($currentPath);

        return $path;
    }

    private static function isBundled(string $path): bool
    {
        return Str::startsWith($path, 'images/');
    }

    private static function disk(): Filesystem
    {
        return Storage::disk(self::DISK);
    }
}
