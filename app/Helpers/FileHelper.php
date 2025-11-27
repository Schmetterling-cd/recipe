<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FileHelper
{
    public static function saveBase64Image($base64String)
    {
        preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches);
        $extension = $matches[1] ?? 'jpg';
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64String));

        $filename = Str::uuid() . '.' . $extension;
        $path = 'uploads/' . $filename;

        Storage::disk('public')->put($path, $imageData);

        return $path;
    }
}
