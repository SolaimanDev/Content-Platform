<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // or Imagick if preferred

class ImageHelper
{
    public static function uploadWithThumbnail($file, $directory = 'uploads')
    {
        // Create image manager with desired driver
        $manager = new ImageManager(new Driver());
        
        $storagePath = $directory;
        Storage::makeDirectory($storagePath);

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($originalName).'-'.time().'.'.$extension;
        $thumbnailFilename = Str::slug($originalName).'-'.time().'_thumb.'.$extension;

        // Store original
        $filePath = $file->storeAs($storagePath, $filename);

        // Create and store thumbnail
        $image = $manager->read($file);
        $thumbnail = $image->cover(300, 200);
        Storage::put(
            "{$storagePath}/{$thumbnailFilename}",
            $thumbnail->encodeByExtension($extension)
        );

        return [
            'original' => "{$directory}/{$filename}",
            'thumbnail' => "{$directory}/{$thumbnailFilename}"
        ];
    }

    public static function getUrl($path)
    {
        return Storage::url($path);
    }

    public static function delete($paths)
    {
        if (is_array($paths)) {
            foreach ($paths as $path) {
                Storage::delete($path);
            }
            return true;
        }
        return Storage::delete($paths);
    }
}