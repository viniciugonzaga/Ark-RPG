<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    public function show($path)
    {
        // Remove barra inicial, se houver
        $path = ltrim($path, '/');

        // Remove o prefixo literal "storage/" (correção: antes usava ltrim($path, 'storage/'),
        // que trata o segundo argumento como uma MÁSCARA de caracteres e não como prefixo,
        // corrompendo paths que começam com letras de "storage/", como "avatars/...")
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        // 1. Tenta buscar no disco 'public' (storage/app/public)
        if (Storage::disk('public')->exists($path)) {
            return $this->respondWithFile(
                Storage::disk('public')->path($path),
                Storage::disk('public')->mimeType($path)
            );
        }

        // 2. Fallback: tenta buscar em public/storage (pasta real ou link simbólico)
        $baseFallback = public_path('storage/' . $path);
        if (file_exists($baseFallback)) {
            return $this->respondWithFile($baseFallback, mime_content_type($baseFallback));
        }

        // 3. Fallback com prefixos comuns (avatars/, characters/)
        $prefixes = ['avatars/', 'characters/'];
        foreach ($prefixes as $prefix) {
            // Evita duplicar o prefixo se o path já vier com ele
            $prefixedPath = str_starts_with($path, $prefix) ? $path : $prefix . $path;

            // Tenta no storage/app/public via Storage
            if (Storage::disk('public')->exists($prefixedPath)) {
                return $this->respondWithFile(
                    Storage::disk('public')->path($prefixedPath),
                    Storage::disk('public')->mimeType($prefixedPath)
                );
            }
            // Tenta em public/storage
            $fullPath = public_path('storage/' . $prefixedPath);
            if (file_exists($fullPath)) {
                return $this->respondWithFile($fullPath, mime_content_type($fullPath));
            }
        }

        // 4. Fallback para uploads antigos
        $fallbackUploads = public_path('uploads/' . $path);
        if (file_exists($fallbackUploads)) {
            return $this->respondWithFile($fallbackUploads, mime_content_type($fallbackUploads));
        }

        // 5. Fallback para public/ (raiz)
        $fallbackRoot = public_path($path);
        if (file_exists($fallbackRoot)) {
            return $this->respondWithFile($fallbackRoot, mime_content_type($fallbackRoot));
        }

        // 6. Se nada funcionar, retorna 404
        abort(404);
    }

    private function respondWithFile($file, $mime)
    {
        return response()->file($file, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}