<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('absensi:ingatkan-guru')->dailyAt('15:00');
Schedule::command('laporan:kirim-rekap-bulanan')->monthlyOn(1, '07:00');
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

// Drain antrian WA tiap menit — ini pengganti "queue worker" yang butuh proses
// background terus-menerus (belum tentu didukung shared hosting). Cron yang
// sudah wajib ada buat schedule:run ini sekalian dipakai buat proses job WA.
Schedule::command('queue:work --stop-when-empty --max-time=50 --tries=3')->everyMinute()->withoutOverlapping();

// Heartbeat — dipakai indikator "Kesehatan Cron" di dashboard admin (poin 4 di bawah).
Schedule::call(fn () => \Illuminate\Support\Facades\Cache::put('scheduler_heartbeat', now()))->everyMinute();
