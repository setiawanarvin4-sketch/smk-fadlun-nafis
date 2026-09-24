<div>
    <!-- SAPAAN -->
    <div class="relative bg-gradient-to-br from-navy to-navy-dark rounded-2xl p-7 text-white mb-6 shadow-lg overflow-hidden">
        <p class="relative text-white/60 text-sm font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
        <h1 class="relative text-xl font-extrabold mt-1.5 tracking-tight">Halo, {{ $guru->nama }}</h1>
        <p class="relative text-white/60 text-sm mt-1.5">{{ $guru->jabatan ?? 'Guru' }} — SMK Fadlun Nafis Bangsri</p>
    </div>

    @if($pengumumanGuru->count())
        <div class="card-premium hover:-translate-y-0 p-5 mb-6">
            <p class="text-sm font-bold text-navy mb-3 flex items-center gap-1.5">📢 Pengumuman Internal</p>
            <div class="space-y-3">
                @foreach($pengumumanGuru as $pg)
                    <div class="border-l-2 border-accent-blue pl-3">
                        <p class="text-sm font-semibold text-navy">{{ $pg->judul }}</p>
                        <p class="text-xs text-[#667085] mt-0.5">{{ $pg->isi }}</p>
                        <p class="text-[10px] text-[#667085] mt-1">{{ $pg->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- KARTU STATISTIK -->
    <div class="grid grid-cols-2 gap-4 mb-3">
        <div class="card-premium p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $absenHariIni }}</p>
                <p class="text-xs text-[#667085]">Kelas Sudah Diabsen Hari Ini</p>
            </div>
        </div>
        <div class="card-premium p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m8-16h.01M11 11h.01M11 15h.01M7 11h.01M7 15h.01M15 11h.01M15 15h.01"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $totalKelas }}</p>
                <p class="text-xs text-[#667085]">Total Kelas di Sekolah</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="card-premium p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500 flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $totalSesiBulanIni }}</p>
                <p class="text-xs text-[#667085]">Sesi Mengajar Bulan Ini</p>
            </div>
        </div>
        <div class="card-premium p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $persenTepatWaktu >= 80 ? 'bg-emerald-500' : 'bg-orange-500' }} flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $persenTepatWaktu }}%</p>
                <p class="text-xs text-[#667085]">Tepat Waktu Bulan Ini</p>
            </div>
        </div>
    </div>

    <!-- CTA ISI ABSENSI -->
    <a href="{{ route('guru.absensi') }}"
       class="group relative block bg-gradient-to-br from-accent-blue to-navy text-white p-7 rounded-2xl mb-8 shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-lg font-extrabold text-white">Isi Absensi Kelas</p>
                <p class="text-sm text-white/75 mt-1">Mulai sesi mengajar dan catat kehadiran siswa</p>
            </div>
            <svg class="w-6 h-6 text-white transition-transform group-hover:translate-x-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
        </div>
    </a>

    <h2 class="h-sub mb-1">Riwayat Mengajar</h2>
    <p class="text-xs text-[#667085] mb-4">Klik salah satu baris untuk lihat detail kehadiran & jurnal.</p>

    <div class="card-premium overflow-hidden hover:-translate-y-0">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                <tr>
                    <th class="p-3.5 font-semibold">Tanggal</th>
                    <th class="p-3.5 font-semibold">Kelas</th>
                    <th class="p-3.5 font-semibold">Mapel</th>
                    <th class="p-3.5 font-semibold">Kehadiran Siswa</th>
                    <th class="p-3.5 font-semibold">Jam Mengajar</th>
                    <th class="p-3.5 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $sesi)
                    @php
                        $hadir = $sesi->absensi->where('status', 'Hadir')->count();
                        $izin = $sesi->absensi->where('status', 'Izin')->count();
                        $sakit = $sesi->absensi->where('status', 'Sakit')->count();
                        $alpha = $sesi->absensi->where('status', 'Alpha')->count();
                    @endphp
                    <tr wire:click="openDetail({{ $sesi->id }})" class="border-t border-[#E5E7EB] cursor-pointer hover:bg-[#F6F7FA] transition-colors">
                        <td class="p-3.5">{{ $sesi->tanggal->translatedFormat('d M Y') }}</td>
                        <td class="p-3.5 font-semibold text-navy">{{ $sesi->kelas->nama_kelas ?? '-' }}</td>
                        <td class="p-3.5">{{ $sesi->mataPelajaran->nama ?? '-' }}</td>
                        <td class="p-3.5">
                            <div class="flex gap-1.5 flex-wrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">{{ $hadir }} Hadir</span>
                                @if($izin) <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">{{ $izin }} Izin</span> @endif
                                @if($sakit) <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700">{{ $sakit }} Sakit</span> @endif
                                @if($alpha) <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">{{ $alpha }} Alpha</span> @endif
                            </div>
                        </td>
                        <td class="p-3.5 text-[#667085]">
                            Jam {{ $sesi->waktu_mulai ? \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') : '-' }}
                            @if($sesi->status_kedatangan === 'Terlambat')
                                <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 align-middle">Terlambat</span>
                            @endif
                        </td>
                        <td class="p-3.5">
                            @if($sesi->waktu_selesai)
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">Selesai</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Sedang Mengajar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-[#667085]">Belum ada riwayat absensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $riwayat->links() }}</div>

    @if($showDetail && $detailSesi)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 overflow-y-auto py-8">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <div class="flex justify-between items-start mb-5">
                    <div>
                        <h2 class="font-bold text-navy text-lg">{{ $detailSesi->kelas->nama_kelas }} — {{ $detailSesi->mataPelajaran->nama }}</h2>
                        <p class="text-sm text-[#667085]">
                            {{ $detailSesi->tanggal->translatedFormat('d F Y') }}
                            @if($detailSesi->status_kedatangan === 'Terlambat')
                                <span class="ml-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 align-middle">Terlambat</span>
                            @endif
                        </p>
                    </div>
                    <button wire:click="$set('showDetail', false)" class="text-[#667085] hover:text-navy w-8 h-8 rounded-lg hover:bg-[#F6F7FA] flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                @if($detailSesi->materi)
                    <div class="bg-[#F6F7FA] rounded-xl p-3.5 mb-5">
                        <p class="text-xs text-[#667085] font-medium mb-1">Materi yang Diajarkan</p>
                        <p class="text-sm text-navy">{{ $detailSesi->materi }}</p>
                    </div>
                @endif

                @if($detailSesi->kegiatan || $detailSesi->kendala)
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        @if($detailSesi->kegiatan)
                            <div class="bg-[#F6F7FA] rounded-xl p-3">
                                <p class="text-xs text-[#667085] font-medium mb-1.5">Kegiatan</p>
                                <p class="text-sm text-navy">{{ $detailSesi->kegiatan }}</p>
                            </div>
                        @endif
                        @if($detailSesi->kendala)
                            <div class="bg-red-50 rounded-xl p-3">
                                <p class="text-xs text-red-500 font-medium mb-1.5">Kendala</p>
                                <p class="text-sm text-red-700">{{ $detailSesi->kendala }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <p class="text-sm font-bold text-navy mb-2">Daftar Kehadiran</p>
                <div class="max-h-64 overflow-y-auto space-y-1">
                    @foreach($detailSesi->absensi as $row)
                        <div class="flex justify-between items-center text-sm border-b border-[#E5E7EB] py-2.5">
                            <span>{{ $row->siswa->nama ?? '-' }}</span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                @class([
                                    'bg-green-50 text-green-700' => $row->status === 'Hadir',
                                    'bg-yellow-50 text-yellow-700' => in_array($row->status, ['Izin', 'Sakit']),
                                    'bg-red-50 text-red-600' => $row->status === 'Alpha',
                                ])">
                                {{ $row->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>