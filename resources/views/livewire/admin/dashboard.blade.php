<div>
    <!-- SAPAAN -->
    <div class="relative bg-gradient-to-br from-navy to-navy-dark rounded-2xl p-8 text-white mb-6 overflow-hidden shadow-lg">
        <p class="relative text-white/60 text-sm font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
        <h1 class="relative text-2xl font-extrabold mt-1.5 tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="relative text-white/60 text-sm mt-1.5">Dashboard Admin — SMK Fadlun Nafis Bangsri</p>
    </div>

    <!-- PERLU TINDAKAN -->
    @if($izinMenunggu || $loginGagal24Jam)
        <div class="bg-white border-2 border-red-100 rounded-2xl p-5 mb-6">
            <p class="text-sm font-bold text-red-600 mb-3 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M10.3 4.6l-7.1 12a2 2 0 001.7 3h14.2a2 2 0 001.7-3l-7.1-12a2 2 0 00-3.4 0z"/>
                </svg>
                Perlu Tindakan
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @if($izinMenunggu)
                    <a href="{{ route('admin.absensi') }}" class="flex items-center justify-between bg-red-50 hover:bg-red-100 rounded-xl px-4 py-3 transition-colors">
                        <span class="text-sm text-red-700"><strong>{{ $izinMenunggu }}</strong> laporan izin guru menunggu persetujuan</span>
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
                @if($loginGagal24Jam)
                    <a href="{{ route('admin.login-log') }}" class="flex items-center justify-between bg-yellow-50 hover:bg-yellow-100 rounded-xl px-4 py-3 transition-colors">
                        <span class="text-sm text-yellow-700"><strong>{{ $loginGagal24Jam }}</strong> percobaan login gagal (24 jam)</span>
                        <svg class="w-4 h-4 text-yellow-600 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- KARTU STATISTIK -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="card-premium p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 4a4 4 0 100 8 4 4 0 000-8zM4 20c0-3.3 3.6-6 8-6s8 2.7 8 6"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $jumlahSiswa }}</p>
                <p class="text-xs text-[#667085]">Siswa Aktif</p>
            </div>
        </div>
        <div class="card-premium p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.02 12.02 0 0112 21a12.02 12.02 0 01-6.16-10.42L12 14z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $jumlahGuru }}</p>
                <p class="text-xs text-[#667085]">Guru Aktif</p>
            </div>
        </div>
        <div class="card-premium p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h11l5 5v9a2 2 0 01-2 2zM9 9h6M9 13h6M9 17h3"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $jumlahBerita }}</p>
                <p class="text-xs text-[#667085]">Berita Published</p>
            </div>
        </div>
        <div class="card-premium p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 6.25L4 10l8 3.75L20 10l-8-3.75zM4 14l8 3.75L20 14M4 10v6c0 1 3.6 3 8 3s8-2 8-3v-6"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-navy tracking-tight">{{ $jumlahKompetensi }}</p>
                <p class="text-xs text-[#667085]">Kompetensi Keahlian</p>
            </div>
        </div>
    </div>

    <div class="card-premium p-4 flex items-center gap-3 mb-6">
        <span class="w-2.5 h-2.5 rounded-full {{ $cronSehat ? 'bg-green-500' : 'bg-red-500' }}"></span>
        <div>
            <p class="text-xs font-semibold text-navy">Kesehatan Cron Server</p>
            <p class="text-xs text-[#667085]">
                {{ $cronTerakhir ? 'Terakhir aktif '.\Carbon\Carbon::parse($cronTerakhir)->diffForHumans() : 'Belum pernah terdeteksi jalan' }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- GRAFIK TREN -->
        <div class="md:col-span-2 card-premium hover:-translate-y-0 p-6">
            <p class="text-sm font-semibold text-navy mb-5">Tren Sesi Mengajar — 7 Hari Terakhir</p>
            <div class="flex items-end justify-between gap-3 h-32">
                @foreach($trenAbsensi as $t)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <span class="text-xs font-bold text-navy">{{ $t['jumlah'] }}</span>
                        <div class="w-full bg-[#F0F1F3] rounded-t-md flex items-end" style="height: 70px;">
                            <div class="w-full bg-gradient-to-t from-accent-blue to-accent-teal rounded-t-md transition-all duration-500"
                                 style="height: {{ $t['jumlah'] > 0 ? max(($t['jumlah'] / $maxTren) * 100, 6) : 0 }}%"></div>
                        </div>
                        <span class="text-[10px] text-[#667085]">{{ $t['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- STATUS PPDB -->
        <div class="card-premium hover:-translate-y-0 p-6 flex flex-col">
            <p class="text-sm font-semibold text-navy mb-3">Status PPDB</p>
            <div class="flex-1 flex flex-col items-center justify-center text-center">
                <span class="px-4 py-2 rounded-full text-sm font-bold mb-2
                    {{ $ppdbStatus === 'Dibuka' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                    PPDB {{ $ppdbStatus }}
                </span>
                <p class="text-xs text-[#667085]">Pendaftaran peserta didik baru</p>
            </div>
            <a href="{{ route('admin.ppdb') }}" class="mt-3 text-center text-xs font-semibold text-accent-blue border border-[#E5E7EB] rounded-lg py-2 hover:bg-[#F6F7FA] transition-colors">Kelola PPDB</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- KOLOM KIRI -->
        <div class="md:col-span-2 space-y-6">
            <!-- RINCIAN SESI HARI INI -->
            <div class="card-premium hover:-translate-y-0 p-6">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm font-semibold text-navy">Sesi Mengajar Hari Ini</p>
                    <span class="text-2xl font-extrabold text-navy">{{ $absenHariIni }}<span class="text-sm text-[#667085] font-medium">/{{ $totalJadwalHariIni }}</span></span>
                </div>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <a href="{{ route('admin.absensi') }}" class="bg-green-50 hover:bg-green-100 rounded-xl py-3 transition-colors">
                        <p class="text-lg font-extrabold text-green-700">{{ $sesiTercatat }}</p>
                        <p class="text-[10px] text-green-700/80">Tercatat</p>
                    </a>
                    <a href="{{ route('admin.absensi') }}" class="bg-blue-50 hover:bg-blue-100 rounded-xl py-3 transition-colors">
                        <p class="text-lg font-extrabold text-accent-blue">{{ $sesiTepatWaktu }}</p>
                        <p class="text-[10px] text-accent-blue/80">Tepat Waktu</p>
                    </a>
                    <div class="bg-gray-50 rounded-xl py-3">
                        <p class="text-lg font-extrabold text-gray-500">{{ $sesiBelumMulai }}</p>
                        <p class="text-[10px] text-gray-500">Belum Mulai</p>
                    </div>
                    <a href="{{ route('admin.absensi') }}" class="bg-red-50 hover:bg-red-100 rounded-xl py-3 transition-colors">
                        <p class="text-lg font-extrabold text-red-600">{{ $sesiTerlambat }}</p>
                        <p class="text-[10px] text-red-600/80">Terlambat</p>
                    </a>
                </div>
            </div>

            <!-- GURU BELUM ABSEN & TIDAK HADIR HARI INI -->
            @if($guruBelumAbsen->isNotEmpty() || $guruTidakHadirHariIni->isNotEmpty())
                <div class="card-premium hover:-translate-y-0 p-6">
                    @if($guruBelumAbsen->isNotEmpty())
                        <p class="text-sm font-semibold text-navy mb-2">⚠️ Belum Isi Absensi ({{ $guruBelumAbsen->count() }})</p>
                        <div class="divide-y divide-[#E5E7EB] mb-4">
                            @foreach($guruBelumAbsen as $j)
                                <div class="py-2 text-sm flex justify-between">
                                    <span class="text-navy font-medium">{{ $j->guru->nama }}</span>
                                    <span class="text-xs text-[#667085]">{{ $j->kelas->nama_kelas }} · {{ $j->mataPelajaran->nama }} · {{ substr($j->jam_mulai, 0, 5) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($guruTidakHadirHariIni->isNotEmpty())
                        <p class="text-sm font-semibold text-navy mb-2">Guru Tidak Hadir Hari Ini ({{ $guruTidakHadirHariIni->count() }})</p>
                        <div class="divide-y divide-[#E5E7EB]">
                            @foreach($guruTidakHadirHariIni as $t)
                                <div class="py-2 text-sm flex justify-between">
                                    <span class="text-navy font-medium">{{ $t->guru->nama }}</span>
                                    <span class="text-xs text-[#667085]">{{ $t->kelas->nama_kelas }} · {{ $t->alasan }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                        @endif

            @if($guruTanpaWa > 0 || $siswaTanpaWaWali > 0)
                <div class="card-premium hover:-translate-y-0 p-6 border-2 border-amber-100">
                    <p class="text-sm font-semibold text-amber-700 mb-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.3 4.6l-7.1 12a2 2 0 001.7 3h14.2a2 2 0 001.7-3l-7.1-12a2 2 0 00-3.4 0z"/>
                        </svg>
                        Data Kontak WA Belum Lengkap
                    </p>
                                        <div class="space-y-1 text-sm text-[#475467]">
                        @if($guruTanpaWa > 0)
                            <p>{{ $guruTanpaWa }} dari {{ $totalGuru }} guru belum punya nomor WA</p>
                        @endif
                        @if($siswaTanpaWaWali > 0)
                            <p>{{ $siswaTanpaWaWali }} dari {{ $totalSiswa }} siswa belum ada kontak WA wali</p>
                        @endif
                    </div>
                    <p class="text-xs text-[#667085] mt-2">Notifikasi otomatis (pengingat guru, Alpha ke ortu) tidak akan terkirim untuk data yang kosong ini.</p>
                </div>
            @endif

            <!-- AKTIVITAS TERBARU -->
            <div class="card-premium overflow-hidden hover:-translate-y-0">
                <div class="p-4 border-b border-[#E5E7EB] flex justify-between items-center">
                    <p class="text-sm font-semibold text-navy">Aktivitas Terbaru</p>
                    <a href="{{ route('admin.activity-log') }}" class="text-xs text-accent-blue font-medium">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#E5E7EB]">
                    @forelse($aktivitasTerbaru as $log)
                        <div class="p-4 flex items-center justify-between text-sm hover:bg-[#F6F7FA] transition-colors">
                            <div>
                                <p class="font-medium">{{ $log->aktivitas }}</p>
                                <p class="text-xs text-[#667085] mt-0.5">
                                    {{ $log->user->name ?? 'Sistem' }} · {{ $log->modul ?? '-' }}
                                </p>
                            </div>
                            <span class="text-xs text-[#667085] whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-[#667085]">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN -->
        <div class="space-y-4">
            @if($agendaTerdekat->isNotEmpty() || $hariKhususTerdekat->isNotEmpty())
                <div class="card-premium hover:-translate-y-0 p-6">
                    <p class="text-sm font-semibold text-navy mb-3">Agenda & Hari Khusus Terdekat</p>
                    <div class="space-y-2">
                        @foreach($agendaTerdekat as $a)
                            <div class="text-sm px-3 py-2 rounded-lg bg-[#F6F7FA]">
                                <p class="font-medium text-navy line-clamp-1">{{ $a->judul }}</p>
                                <p class="text-xs text-[#667085]">{{ $a->tanggal->translatedFormat('d M Y') }}{{ $a->jam ? ' · '.$a->jam : '' }}</p>
                            </div>
                        @endforeach
                        @foreach($hariKhususTerdekat as $h)
                            <div class="text-sm px-3 py-2 rounded-lg bg-amber-50">
                                <p class="font-medium text-navy">Pulang Cepat: {{ $h->jam_pulang }}</p>
                                <p class="text-xs text-[#667085]">{{ \Carbon\Carbon::parse($h->tanggal)->translatedFormat('d M Y') }}{{ $h->keterangan ? ' · '.$h->keterangan : '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- BERITA TERBARU -->
            <div class="card-premium hover:-translate-y-0 overflow-hidden">
                <div class="p-4 border-b border-[#E5E7EB] flex justify-between items-center">
                    <p class="text-sm font-semibold text-navy">Berita Terbaru</p>
                    <a href="{{ route('admin.berita') }}" class="text-xs text-accent-blue font-medium">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#E5E7EB]">
                    @forelse($beritaTerbaru as $b)
                        <div class="p-3.5 text-sm">
                            <p class="font-medium text-navy line-clamp-1">{{ $b->judul }}</p>
                            <p class="text-xs text-[#667085] mt-0.5">
                                {{ $b->tanggal_publikasi?->translatedFormat('d M Y') }}
                                <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $b->status === 'published' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $b->status === 'published' ? 'Terbit' : 'Draft' }}</span>
                            </p>
                        </div>
                    @empty
                        <div class="p-4 text-center text-xs text-[#667085]">Belum ada berita.</div>
                    @endforelse
                </div>
            </div>

            <!-- PRESTASI TERBARU -->
            <div class="card-premium hover:-translate-y-0 overflow-hidden">
                <div class="p-4 border-b border-[#E5E7EB] flex justify-between items-center">
                    <p class="text-sm font-semibold text-navy">Prestasi Terbaru</p>
                    <a href="{{ route('admin.prestasi') }}" class="text-xs text-accent-blue font-medium">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#E5E7EB]">
                    @forelse($prestasiTerbaru as $p)
                        <div class="p-3.5 text-sm">
                            <p class="font-medium text-navy line-clamp-1">{{ $p->judul }}</p>
                            <p class="text-xs text-[#667085] mt-0.5">{{ $p->tingkat ?? '-' }} · {{ $p->tahun }}</p>
                        </div>
                    @empty
                        <div class="p-4 text-center text-xs text-[#667085]">Belum ada prestasi.</div>
                    @endforelse
                </div>
            </div>

            <!-- AKSES CEPAT -->
            <div class="card-premium p-6 hover:-translate-y-0">
                <p class="text-sm font-semibold text-navy mb-3">Akses Cepat</p>
                <div class="space-y-2">
                    @can('kelola-data')
                        <a href="{{ route('admin.siswa') }}" class="block text-sm px-3 py-2 rounded-lg bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue transition-colors">+ Tambah Siswa</a>
                        <a href="{{ route('admin.berita') }}" class="block text-sm px-3 py-2 rounded-lg bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue transition-colors">+ Tulis Berita</a>
                    @endcan
                    <a href="{{ route('admin.absensi') }}" class="block text-sm px-3 py-2 rounded-lg bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue transition-colors">Lihat Rekap Absensi</a>
                    <a href="{{ route('admin.cetak.siswa') }}" target="_blank" class="block text-sm px-3 py-2 rounded-lg bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue transition-colors">Cetak Data Siswa</a>
                    <a href="{{ route('admin.cetak.guru') }}" target="_blank" class="block text-sm px-3 py-2 rounded-lg bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue transition-colors">Cetak Data Guru</a>                </div>
            </div>
        </div>
    </div>
</div>