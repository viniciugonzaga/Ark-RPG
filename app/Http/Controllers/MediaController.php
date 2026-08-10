<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    public function show(string $path): StreamedResponse
    {
        $disk = Storage::disk(config('filesystems.image_disk', 'public'));

        abort_unless($disk->exists($path), 404);

        return $disk->response($path);
    }
}