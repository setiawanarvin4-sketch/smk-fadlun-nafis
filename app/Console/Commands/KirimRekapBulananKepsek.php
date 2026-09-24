<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Exports\RekapKehadiranGuruBulananExport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KirimRekapBulananKepsek extends Command
{
    protected $signature = 'laporan:kirim-rekap-bulanan';
    protected $description = 'Generate & kirim rekap kehadiran guru bulan lalu ke semua akun Kepala Sekolah';

    public function handle(): void
    {
        $bulanLalu = now()->subMonth();
        $namaBulan = $bulanLalu->translatedFormat('F Y');
        $fileName = 'rekap-guru-'.$bulanLalu->format('Y-m').'.xlsx';

        $penerima = User::where('role', 'kepala_sekolah')->pluck('email');

        if ($penerima->isEmpty()) {
            $this->warn('Tidak ada akun Kepala Sekolah, laporan tidak dikirim.');
            return;
        }

        Excel::store(new RekapKehadiranGuruBulananExport($bulanLalu->month, $bulanLalu->year), $fileName);
        $path = storage_path('app/'.$fileName);

        $berhasil = 0;
        foreach ($penerima as $email) {
            try {
                Mail::raw("Terlampir rekap kehadiran mengajar seluruh guru untuk bulan {$namaBulan}.", function ($msg) use ($email, $namaBulan, $path) {
                    $msg->to($email)
                        ->subject("Rekap Kehadiran Guru - {$namaBulan}")
                        ->attach($path);
                });
                $berhasil++;
            } catch (\Throwable $e) {
                report($e);
                $this->error("Gagal kirim ke {$email}: ".$e->getMessage());
            }
        }

        Storage::delete($fileName);

        $this->info("Rekap bulanan terkirim ke {$berhasil} dari {$penerima->count()} akun Kepala Sekolah.");
    }
}