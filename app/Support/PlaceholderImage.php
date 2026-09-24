<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaceholderImage
{
    /**
     * Bikin gambar placeholder sederhana (SVG) dengan warna & teks,
     * simpan ke storage/app/public/{folder}, kembalikan path relatifnya.
     */
    public static function make(string $folder, string $label, string $color = '#16233F'): string
    {
        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="640" height="400">
            <rect width="640" height="400" fill="{$color}"/>
            <text x="50%" y="50%" fill="white" font-family="Arial" font-size="28"
                text-anchor="middle" dominant-baseline="middle">{$label}</text>
        </svg>
        SVG;

        $path = $folder.'/'.Str::random(20).'.svg';
        Storage::disk('public')->put($path, $svg);

        return $path;
    }
}