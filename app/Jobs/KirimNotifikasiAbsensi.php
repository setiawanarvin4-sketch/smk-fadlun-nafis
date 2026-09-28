<?php

namespace App\Jobs;

use App\Models\Siswa;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class KirimNotifikasiAbsensi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(public int $siswaId, public string $pesan) {}

    public function handle(): void
    {
        $siswa = Siswa::find($this->siswaId);
        if ($siswa?->no_wa_wali) {
            WhatsappService::kirim($siswa->no_wa_wali, $this->pesan);
        }
    }
}