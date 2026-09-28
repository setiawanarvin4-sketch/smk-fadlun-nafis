<div>
    <div class="flex justify-between items-center mb-1 flex-wrap gap-2">
        <h1 class="h-sub">Wali Kelas</h1>
        @if($kelas)
            <button wire:click="exportRekap" class="btn-secondary text-xs">Unduh Rekap Excel</button>
        @endif
    </div>
    <p class="text-sm text-[#667085] mb-4">Rekap kehadiran kelas per bulan</p>

    @if(!$kelas)
        <div class="bg-yellow-50 text-yellow-700 text-sm rounded-xl p-4">
            Kamu belum ditugaskan sebagai wali kelas manapun.
        </div>
    @else
        <div class="flex gap-2 items-center mb-4">
            <select wire:model.live="bulan" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                @foreach(range(1,12) as $b)
                    <option value="{{ $b }}">{{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="tahun" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                @foreach(range(now()->year, now()->year - 2) as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="bg-white border-2 border-navy/10 rounded-2xl p-4 mb-5">
            <p class="text-sm font-semibold text-navy">Kelas {{ $kelas->nama_kelas }}</p>
            <p class="text-xs text-[#667085] mt-0.5">{{ $rekap->count() }} siswa aktif</p>
        </div>

        <div class="card-premium hover:-translate-0 overflow-hidden mb-5">
            <p class="text-sm font-semibold text-navy p-4 pb-2">Rekap Kehadiran</p>
            <p class="text-xs text-[#667085] px-4 pb-2">Klik angka Alpha untuk lihat detail tanggal. Baris merah = perlu diperhatikan (Alpha ≥ 3).</p>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3 text-center">Hadir</th>
                            <th class="p-3 text-center">Izin</th>
                            <th class="p-3 text-center">Sakit</th>
                            <th class="p-3 text-center">Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekap as $r)
                            <tr class="border-t border-[#E5E7EB] {{ $r->alpha >= 3 ? 'bg-red-50' : '' }}">
                                <td class="p-3 {{ $r->alpha >= 3 ? 'font-semibold text-red-700' : '' }}">
                                    {{ $r->nama }}
                                    @if($r->alpha >= 3)
                                        <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600">Perlu Perhatian</span>
                                    @endif
                                </td>
                                <td class="p-3 text-center text-green-700">{{ $r->hadir }}</td>
                                <td class="p-3 text-center text-yellow-700">{{ $r->izin }}</td>
                                <td class="p-3 text-center text-orange-700">{{ $r->sakit }}</td>
                                <td class="p-3 text-center">
                                    <button wire:click="lihatDetail({{ $r->id }})" class="text-red-600 font-semibold underline decoration-dotted hover:text-red-700">{{ $r->alpha }}</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-premium hover:-translate-y-0 overflow-hidden mb-5">
            <p class="text-sm font-semibold text-navy p-4 pb-2">Jurnal Mengajar Terbaru</p>
            <div class="divide-y divide-[#E5E7EB]">
                @forelse($jurnalTerbaru as $j)
                    <div class="p-4">
                        <p class="text-sm font-medium">{{ $j->mataPelajaran->nama ?? '-' }} — {{ $j->tanggal->translatedFormat('d M Y') }}</p>
                        @if($j->materi)<p class="text-xs text-[#667085] mt-1">Materi: {{ $j->materi }}</p>@endif
                        @if($j->kegiatan)<p class="text-xs text-[#667085] mt-1">Kegiatan: {{ $j->kegiatan }}</p>@endif
                        @if($j->kendala)<p class="text-xs text-red-500 mt-1">Kendala: {{ $j->kendala }}</p>@endif
                    </div>
                @empty
                    <p class="text-sm text-[#667085] p-4">Belum ada jurnal bulan ini.</p>
                @endforelse
            </div>
        </div>
    @endif

    @if($detailSiswaId)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-navy text-lg">Detail Kehadiran — {{ $detailSiswaNama }}</h2>
                    <button wire:click="tutupDetail" class="text-[#667085]">&times;</button>
                </div>
                <div class="divide-y divide-[#E5E7EB] max-h-96 overflow-y-auto">
                    @forelse($detailAbsensi as $a)
                        <div class="py-2 flex justify-between items-center text-sm">
                            <div>
                                <p class="font-medium text-navy">{{ $a->sesiMengajar->tanggal->translatedFormat('d M Y') }}</p>
                                <p class="text-xs text-[#667085]">{{ $a->sesiMengajar->mataPelajaran->nama ?? '-' }}</p>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $a->status === 'Hadir' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $a->status === 'Izin' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                {{ $a->status === 'Sakit' ? 'bg-orange-50 text-orange-700' : '' }}
                                {{ $a->status === 'Alpha' ? 'bg-red-50 text-red-700' : '' }}">
                                {{ $a->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-[#667085] py-4">Tidak ada data.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>