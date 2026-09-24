<?php

namespace App\Services;

use App\Models\PengaturanSitus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Kirim satu pesan WhatsApp lewat gateway yang dikonfigurasi di Admin > Pengaturan.
     * Didesain untuk gateway bergaya Fonnte (POST ke endpoint, header Authorization berisi token,
     * body berisi target & message). Kalau nanti pakai provider lain yang formatnya beda,
     * sesuaikan bagian Http::withHeaders(...)->post(...) di bawah.
     *
     * Method ini SENGAJA tidak pernah melempar exception ke pemanggilnya — kalau WA gagal
     * terkirim (gateway down, token salah, dll), itu tidak boleh menggagalkan proses absensi.
     * Kegagalan dicatat ke log saja.
     */
    public static function kirim(?string $nomorTujuan, string $pesan): bool
    {
        $pengaturan = PengaturanSitus::current();

        if (! $pengaturan->wa_notifikasi_aktif) {
            return false;
        }

        if (! $nomorTujuan || ! $pengaturan->wa_gateway_token || ! $pengaturan->wa_gateway_endpoint) {
            Log::info('WhatsappService: dilewati (konfigurasi belum lengkap atau nomor tujuan kosong).', [
                'nomor_tujuan' => $nomorTujuan,
                'gateway_terisi' => (bool) $pengaturan->wa_gateway_endpoint,
                'token_terisi' => (bool) $pengaturan->wa_gateway_token,
            ]);
            return false;
        }

        $nomorRapi = self::rapikanNomor($nomorTujuan);

        try {
            $response = Http::timeout(15)
                ->withHeaders(['Authorization' => $pengaturan->wa_gateway_token])
                ->asForm()
                ->post($pengaturan->wa_gateway_endpoint, [
                    'target' => $nomorRapi,
                    'message' => $pesan,
                ]);

            if (! $response->successful()) {
                Log::warning('WhatsappService: gateway membalas status gagal.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('WhatsappService: gagal mengirim pesan.', ['pesan_error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Ubah nomor lokal (08xxx) jadi format internasional (62xxx) yang umum dipakai gateway WA.
     */
    private static function rapikanNomor(string $nomor): string
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        if (str_starts_with($nomor, '0')) {
            $nomor = '62'.substr($nomor, 1);
        }

        return $nomor;
    }
}