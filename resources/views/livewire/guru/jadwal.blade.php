<div>
    <div class="flex items-center justify-between mb-1">
        <h1 class="h-sub">Jadwal Mengajar Mingguan</h1>
        <span class="text-sm text-[#667085]">{{ $totalJam }} jam pelajaran/minggu</span>
    </div>
    <p class="text-sm text-[#667085] mb-6">Jadwal mengajar reguler kamu, Senin–Sabtu.</p>

    <div class="space-y-5">
        @foreach($hariUrutan as $hari)
            <div class="card-premium hover:-translate-y-0 overflow-hidden">
                <div class="bg-[#F6F7FA] px-5 py-3 border-b border-[#E5E7EB] flex items-center justify-between">
                    <p class="font-bold text-navy text-sm">{{ $hari }}</p>
                    <span class="text-xs text-[#667085]">{{ $jadwalPerHari->get($hari, collect())->count() }} jam pelajaran</span>
                </div>
                @if($jadwalPerHari->get($hari, collect())->isEmpty())
                    <p class="text-sm text-[#667085] p-5">Tidak ada jadwal mengajar.</p>
                @else
                    <div class="divide-y divide-[#E5E7EB]">
                        @foreach($jadwalPerHari->get($hari) as $j)
                            <div class="flex items-center gap-4 px-5 py-3">
                                <div class="w-16 flex-shrink-0 text-center">
                                    <p class="text-sm font-bold text-navy">{{ substr($j->jam_mulai, 0, 5) }}</p>
                                    <p class="text-[10px] text-[#667085]">{{ substr($j->jam_selesai, 0, 5) }}</p>
                                </div>
                                <div class="w-px h-8 bg-[#E5E7EB]"></div>
                                <div>
                                    <p class="text-sm font-semibold text-navy">{{ $j->mataPelajaran->nama ?? '-' }}</p>
                                    <p class="text-xs text-[#667085] mt-0.5">{{ $j->kelas->nama_kelas ?? '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>