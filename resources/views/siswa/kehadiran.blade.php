<x-layouts.siswa>
    <h1 class="h-section mb-6">Riwayat Kehadiran</h1>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @php
            $warnaKelas = ['Hadir' => 'text-emerald-600', 'Izin' => 'text-amber-600', 'Sakit' => 'text-blue-600', 'Alpha' => 'text-red-600'];
        @endphp
        @foreach($warnaKelas as $status => $kelas)
            <div class="card-premium p-4 text-center">
                <p class="text-2xl font-extrabold {{ $kelas }}">{{ $rekapAbsensi[$status] ?? 0 }}</p>
                <p class="text-xs text-[#667085] mt-1">{{ $status }}</p>
            </div>
        @endforeach
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                    <tr>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Mata Pelajaran</th>
                        <th class="p-3">Guru</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatAbsensi as $a)
                        <tr class="border-t border-[#E5E7EB]">
                            <td class="p-3">{{ $a->sesiMengajar?->tanggal?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td class="p-3">{{ $a->sesiMengajar?->mataPelajaran?->nama ?? '-' }}</td>
                            <td class="p-3">{{ $a->sesiMengajar?->guru?->nama ?? '-' }}</td>
                            <td class="p-3">
                                @php
                                    $badge = ['Hadir' => 'bg-emerald-50 text-emerald-700', 'Izin' => 'bg-amber-50 text-amber-700', 'Sakit' => 'bg-blue-50 text-blue-700', 'Alpha' => 'bg-red-50 text-red-700'][$a->status] ?? 'bg-gray-50 text-gray-700';
                                @endphp
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badge }}">{{ $a->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-6 text-center text-[#98A2B3]">Belum ada data kehadiran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $riwayatAbsensi->links() }}</div>
</x-layouts.siswa>