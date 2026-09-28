<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

/**
 * Token gateway WhatsApp (pengaturan_situs.wa_gateway_token) sebelumnya tersimpan
 * plain text di database. Kolom ini sekarang di-cast 'encrypted' di model
 * PengaturanSitus, tapi cast itu tidak otomatis mengenkripsi nilai LAMA yang
 * sudah tersimpan — kalau tidak dienkripsi manual dulu di sini, saat aplikasi
 * mencoba men-decrypt nilai plain text lama, akan lempar DecryptException.
 *
 * Migrasi ini idempotent: kalau dijalankan dua kali (atau nilainya memang sudah
 * terenkripsi), token yang sudah berbentuk cipher text Laravel tidak akan
 * dienkripsi ulang.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('pengaturan_situs')->whereNotNull('wa_gateway_token')->where('wa_gateway_token', '!=', '')
            ->get(['id', 'wa_gateway_token'])
            ->each(function ($row) {
                if ($this->sudahTerenkripsi($row->wa_gateway_token)) {
                    return;
                }

                DB::table('pengaturan_situs')->where('id', $row->id)->update([
                    'wa_gateway_token' => Crypt::encryptString($row->wa_gateway_token),
                ]);
            });
    }

    public function down(): void
    {
        DB::table('pengaturan_situs')->whereNotNull('wa_gateway_token')->where('wa_gateway_token', '!=', '')
            ->get(['id', 'wa_gateway_token'])
            ->each(function ($row) {
                if (! $this->sudahTerenkripsi($row->wa_gateway_token)) {
                    return;
                }

                DB::table('pengaturan_situs')->where('id', $row->id)->update([
                    'wa_gateway_token' => Crypt::decryptString($row->wa_gateway_token),
                ]);
            });
    }

    private function sudahTerenkripsi(string $value): bool
    {
        try {
            Crypt::decryptString($value);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
};
