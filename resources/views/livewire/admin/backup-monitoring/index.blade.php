<div>
    <h1 class="text-xl font-extrabold text-navy tracking-tight mb-4">Monitoring Backup</h1>

    @if($error)
        <div class="card-premium p-6 border-2 border-red-100">
            <p class="text-sm font-bold text-red-600 mb-1">Gagal memuat status backup</p>
            <p class="text-xs text-[#667085]">{{ $error }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($destinations as $d)
                <div class="card-premium p-6">
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-sm font-semibold text-navy">Disk: {{ $d['disk'] }}</p>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $d['reachable'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $d['reachable'] ? 'Terhubung' : 'Bermasalah' }}
                        </span>
                    </div>
                    <div class="space-y-1.5 text-sm text-[#475467]">
                        <p>Backup terbaru: <span class="font-semibold text-navy">{{ $d['tanggal_terbaru']?->translatedFormat('d M Y, H:i') ?? 'Belum ada' }}</span></p>
                        <p>Ukuran backup terbaru: <span class="font-semibold text-navy">{{ $d['ukuran_terbaru'] ? $this->formatUkuran($d['ukuran_terbaru']) : '-' }}</span></p>
                        <p>Jumlah arsip tersimpan: <span class="font-semibold text-navy">{{ $d['jumlah'] }}</span></p>
                        <p>Total ukuran penyimpanan: <span class="font-semibold text-navy">{{ $this->formatUkuran($d['total_ukuran']) }}</span></p>
                    </div>
                    @if($d['tanggal_terbaru'] && $d['tanggal_terbaru']->lt(now()->subDay()))
                        <p class="mt-3 text-xs text-amber-600 bg-amber-50 rounded-lg px-3 py-2">⚠️ Backup terbaru lebih dari 24 jam yang lalu. Cek jadwal cron / scheduler di server.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>