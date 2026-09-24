<div>
    <h1 class="h-sub mb-1">Wali Kelas</h1>
    <p class="text-sm text-[#667085] mb-6">{{ now()->translatedFormat('F Y') }}</p>

    @if(!$kelas)
        <div class="bg-yellow-50 text-yellow-700 text-sm rounded-xl p-4">
            Kamu belum ditugaskan sebagai wali kelas manapun.
        </div>
    @else
        <div class="bg-white border-2 border-navy/10 rounded-2xl p-4 mb-5">
            <p class="text-sm font-semibold text-navy">Kelas {{ $kelas->nama_kelas }}</p>
            <p class="text-xs text-[#667085] mt-0.5">{{ $rekap->count() }} siswa aktif</p>
        </div>

        <div class="card-premium hover:-translate-y-0 overflow-hidden mb-5">
            <p class="text-sm font-semibold text-navy p-4 pb-2">Rekap Kehadiran Bulan Ini</p>
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
                            <tr class="border-t border-[#E5E7EB]">
                                <td class="p-3">{{ $r->nama }}</td>
                                <td class="p-3 text-center text-green-700">{{ $r->hadir }}</td>
                                <td class="p-3 text-center text-yellow-700">{{ $r->izin }}</td>
                                <td class="p-3 text-center text-orange-700">{{ $r->sakit }}</td>
                                <td class="p-3 text-center text-red-600 font-semibold">{{ $r->alpha }}</td>
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
</div>