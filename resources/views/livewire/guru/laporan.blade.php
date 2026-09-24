<div>
    <div class="flex items-center justify-between mb-1 print:hidden">
        <h1 class="h-sub">Laporan Kehadiran Mengajar</h1>
        <div class="flex items-center gap-3">
        <input type="month" wire:model.live="bulan" class="border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm">

        <button wire:click="exportSemester" class="btn-secondary text-sm">
            Export Rekap Semester
        </button>

        <button onclick="window.print()" class="btn-primary !px-4 !py-2 text-sm">
            Cetak / Simpan PDF
        </button>
    </div> 
    </div>
    <p class="text-sm text-[#667085] mb-6 print:hidden">Pilih bulan, lalu cetak sebagai lampiran laporan kinerja.</p>

    <div id="area-cetak" class="card-premium hover:-translate-y-0 p-7 print:shadow-none print:border-0">
        <div class="text-center mb-6 pb-6 border-b border-[#E5E7EB]">
            <p class="font-bold text-navy text-lg">Laporan Kehadiran Mengajar</p>
            <p class="text-sm text-[#667085] mt-1">{{ $guru->nama }} — {{ $namaBulan }}</p>
            <p class="text-xs text-[#667085] mt-0.5">SMK Fadlun Nafis Bangsri</p>
        </div>

        <div class="grid grid-cols-4 gap-3 mb-6">
            <div class="text-center border border-[#E5E7EB] rounded-xl p-3">
                <p class="text-xl font-extrabold text-navy">{{ $totalSesi }}</p>
                <p class="text-[10px] text-[#667085]">Total Sesi</p>
            </div>
            <div class="text-center border border-[#E5E7EB] rounded-xl p-3">
                <p class="text-xl font-extrabold text-green-600">{{ $tepatWaktu }}</p>
                <p class="text-[10px] text-[#667085]">Tepat Waktu</p>
            </div>
            <div class="text-center border border-[#E5E7EB] rounded-xl p-3">
                <p class="text-xl font-extrabold text-red-600">{{ $terlambat }}</p>
                <p class="text-[10px] text-[#667085]">Terlambat</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-navy text-left text-[#667085]">
                        <th class="py-2 pr-2">Tanggal</th>
                        <th class="py-2 pr-2">Kelas</th>
                        <th class="py-2 pr-2">Mapel</th>
                        <th class="py-2 pr-2">Jam</th>
                        <th class="py-2 pr-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesi as $s)
                        <tr class="border-b border-[#EDEEF0]">
                            <td class="py-2 pr-2">{{ $s->tanggal->format('d/m/Y') }}</td>
                            <td class="py-2 pr-2">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td class="py-2 pr-2">{{ $s->mataPelajaran->nama ?? '-' }}</td>
                            <td class="py-2 pr-2">{{ substr($s->waktu_mulai, 0, 5) }}@if($s->waktu_selesai) - {{ substr($s->waktu_selesai, 0, 5) }} @endif</td>
                            <td class="py-2 pr-2">
                                {{ $s->status_kedatangan }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-6 text-center text-[#667085]">Tidak ada data untuk bulan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-10 pt-6 flex justify-end print:mt-16">
            <div class="text-center text-sm">
                <p>Bangsri, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="mt-16 font-semibold">{{ $guru->nama }}</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #area-cetak, #area-cetak * { visibility: visible; }
    #area-cetak { position: absolute; top: 0; left: 0; width: 100%; }
}
</style>