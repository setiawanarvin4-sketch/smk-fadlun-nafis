<?php

namespace App\Livewire\Admin\BackupMonitoring;

use Livewire\Component;
use Spatie\Backup\Config\Config;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;

class Index extends Component
{
    public function render()
    {
        $destinations = collect();
        $error = null;

        try {
            $config = Config::fromArray(config('backup'));
            $destinations = BackupDestinationFactory::createFromArray($config)->map(function ($destination) {
                $terbaru = $destination->newestBackup();

                return [
                    'disk' => $destination->diskName(),
                    'reachable' => $destination->isReachable(),
                    'jumlah' => $destination->backups()->count(),
                    'tanggal_terbaru' => $terbaru?->date(),
                    'ukuran_terbaru' => $terbaru?->sizeInBytes(),
                    'total_ukuran' => $destination->usedStorage(),
                ];
            });
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }

        return view('livewire.admin.backup-monitoring.index', [
            'destinations' => $destinations,
            'error' => $error,
        ]);
    }
    public function formatUkuran(?int $bytes): string
    {
        if (! $bytes || $bytes <= 0) {
            return '0 B';
        }

        $unit = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = (int) floor(log($bytes, 1024));
        $i = min($i, count($unit) - 1);

        return round($bytes / (1024 ** $i), 2).' '.$unit[$i];
    }
}