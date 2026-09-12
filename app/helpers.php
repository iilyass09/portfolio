<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('asset_url')) {
    /**
     * Resolve an asset path to a usable URL.
     *
     * Handles three kinds of paths:
     * - Full URLs (http/https) returned as-is.
     * - Files that live directly under public/ (img/, tanggap/, pantau/, ...).
     * - Files stored on the public disk via upload (projects/..., etc).
     */
    function asset_url(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }

        if (preg_match('#^(https?:)?//#i', $path)) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (is_file(public_path($path))) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}