<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Simpan file upload dengan resize otomatis, supaya beban halaman publik
 * lebih ringan (foto dari HP biasanya 3-4 MB / 4000px, padahal cuma
 * ditampilkan sebagai thumbnail kecil). Kalau proses resize gagal (misal
 * ekstensi GD tidak aktif di server, atau formatnya tidak didukung), kode
 * ini otomatis jatuh ke cara lama: simpan file asli apa adanya, supaya
 * upload tidak sampai gagal total gara-gara fitur tambahan ini.
 */
class ImageUploader
{
    public static function simpan(UploadedFile $file, string $folder, int $lebarMaks = 1200, string $disk = 'public'): string
    {
        $namaFile = $folder.'/'.uniqid().'.'.($file->getClientOriginalExtension() ?: 'jpg');

        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->decodePath($file->getRealPath());
            $image->scaleDown(width: $lebarMaks);

            Storage::disk($disk)->makeDirectory($folder);
            $image->save(Storage::disk($disk)->path($namaFile));

            return $namaFile;
        } catch (\Throwable $e) {
            report($e);

            return $file->storeAs($folder, basename($namaFile), $disk);
        }
    }
}