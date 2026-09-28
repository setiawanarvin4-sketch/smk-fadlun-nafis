<x-layouts.siswa>
    <h1 class="h-section mb-6">Halo, {{ $siswa->nama }} 👋</h1>

    {{-- Biodata ringkas --}}
    <div class="card-premium p-6 mb-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center">
        @if($siswa->foto)
            <img src="{{ asset('storage/'.$siswa->foto) }}" class="w-16 h-16 rounded-2xl object-cover">
        @else
            <div class="w-16 h-16 rounded-2xl bg-navy/5 flex items-center justify-center font-extrabold text-xl text-navy/40">
                {{ substr($siswa->nama, 0, 1) }}
            </div>
        @endif
        <div class="text-sm">
            <p class="font-bold text-navy">{{ $siswa->nama }}</p>
            <p class="text-[#667085] mt-0.5">{{ $siswa->kelas->nama_kelas ?? '-' }} &middot; {{ $siswa->kompetensi->nama ?? '-' }}</p>
        </div>
    </div>

    {{-- Rekap kehadiran semester berjalan --}}
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

    {{-- Jadwal hari ini --}}
    <div class="flex items-center justify-between mb-3">
        <h3 class="h-sub">Jadwal Hari Ini <span class="text-[#98A2B3] font-normal text-sm">({{ $hariIni }})</span></h3>
        <a href="{{ route('siswa.jadwal') }}" class="text-xs font-medium text-accent-blue hover:underline">Lihat Jadwal Lengkap</a>
    </div>
    <div class="card-premium overflow-hidden mb-6">
        @forelse($jadwalHariIni as $j)
            <div class="flex items-center gap-4 p-4 {{ !$loop->last ? 'border-b border-[#E5E7EB]' : '' }}">
                <div class="text-center flex-shrink-0 w-14">
                    <p class="text-xs font-bold text-navy">{{ \Illuminate\Support\Carbon::parse($j->jam_mulai)->format('H:i') }}</p>
                    <p class="text-[10px] text-[#98A2B3]">{{ \Illuminate\Support\Carbon::parse($j->jam_selesai)->format('H:i') }}</p>
                </div>
                <div class="w-px self-stretch bg-[#E5E7EB]"></div>
                <div>
                    <p class="font-semibold text-sm text-navy">{{ $j->mataPelajaran->nama ?? '-' }}</p>
                    <p class="text-xs text-[#667085] mt-0.5">{{ $j->guru->nama ?? '-' }}</p>
                </div>
            </div>
        @empty
            <p class="p-6 text-center text-sm text-[#98A2B3]">Tidak ada jadwal pelajaran hari ini.</p>
        @endforelse
    </div>

    {{-- Prestasi teaser --}}
    @if($prestasiTerbaru->count())
        <div class="flex items-center justify-between mb-3">
            <h3 class="h-sub">Prestasi Terbaru</h3>
            <a href="{{ route('siswa.prestasi') }}" class="text-xs font-medium text-accent-blue hover:underline">Lihat Semua</a>
        </div>
        <div class="card-premium overflow-hidden">
            <ul class="divide-y divide-[#E5E7EB]">
                @foreach($prestasiTerbaru as $p)
                    <li class="p-4 flex justify-between items-center">
                        <span class="font-medium text-sm">{{ $p->judul }}</span>
                        <span class="text-xs text-[#667085]">{{ $p->tahun }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</x-layouts.siswa>