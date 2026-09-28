<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home', [
        'heroSliders' => \App\Models\HeroSlider::where('aktif', true)->orderBy('urutan')->get(),
        'beritaTerbaru' => \App\Models\Berita::published()->with('penulis')->orderByDesc('tanggal_publikasi')->limit(3)->get(),
        'sambutan' => \App\Models\SambutanKepsek::current(),
        'pengumuman' => \App\Models\Pengumuman::where('aktif', true)->latest()->first(),
        'statistikAsli' => [
            ['label' => 'Siswa Aktif', 'nilai' => \App\Models\Siswa::where('aktif', true)->count()],
            ['label' => 'Guru & Tenaga Pendidik', 'nilai' => \App\Models\Guru::where('aktif', true)->count()],
            ['label' => 'Program Keahlian', 'nilai' => \App\Models\Kompetensi::where('aktif', true)->count()],
            ['label' => 'Prestasi Diraih', 'nilai' => \App\Models\Prestasi::count()],
        ],
        'kompetensiList' => \App\Models\Kompetensi::where('aktif', true)->orderBy('urutan')->get(),
        'prestasiTerbaru' => \App\Models\Prestasi::orderByDesc('tahun')->limit(20)->get(),
        'siswaBerprestasi' => \App\Models\Prestasi::whereNotNull('siswa_id')->with('siswa')->orderByDesc('tahun')->limit(30)->get()->unique('siswa_id')->take(16),
        'agendaList' => \App\Models\Agenda::orderByDesc('tanggal')->limit(3)->get(),
        'galeriTerbaru' => \App\Models\Galeri::where('aktif', true)->orderByDesc('id')->limit(4)->get(),
        'ekstrakurikulerList' => \App\Models\Ekstrakurikuler::where('aktif', true)->get(),
    ]);
})->name('home');

Route::prefix('berita')->name('public.')->group(function () {
    Route::get('/', fn () => view('public.berita'))->name('berita');
    Route::get('/{slug}', fn ($slug) => view('public.berita-show', ['slug' => $slug]))->name('berita.show');
});

Route::get('/profil', function () {
    return view('public.profil', [
        'profil' => \App\Models\ProfilSekolah::current(),
        'sambutan' => \App\Models\SambutanKepsek::current(),
    ]);
})->name('public.profil');

Route::get('/akademik', function () {
    return view('public.akademik', [
        'kompetensiList' => \App\Models\Kompetensi::where('aktif', true)->orderBy('urutan')->get(),
    ]);
})->name('public.akademik');

Route::get('/akademik/{slug}', function ($slug) {
    return view('public.akademik-show', [
        'kompetensi' => \App\Models\Kompetensi::where('slug', $slug)->firstOrFail(),
    ]);
})->name('public.akademik.show');

Route::get('/guru-tenaga-kependidikan', function () {
    return view('public.guru', [
        'guruList' => \App\Models\Guru::where('aktif', true)->orderBy('nama')->get(),
        'profil' => \App\Models\ProfilSekolah::current(),
    ]);
})->name('public.guru');

Route::get('/data-siswa', fn () => view('public.siswa'))
    ->name('public.siswa')
    ->middleware('throttle:30,1');
Route::get('/data-siswa/{id}', fn ($id) => view('public.siswa-show', ['id' => $id]))
    ->name('public.siswa.show')
    ->middleware('throttle:30,1');
Route::get('/ekstrakurikuler', function () {
    return view('public.ekstrakurikuler', [
        'items' => \App\Models\Ekstrakurikuler::where('aktif', true)->orderBy('nama')->get(),
    ]);
})->name('public.ekstrakurikuler');

Route::get('/ekstrakurikuler/{id}', function ($id) {
    return view('public.ekstrakurikuler-show', [
        'item' => \App\Models\Ekstrakurikuler::findOrFail($id),
    ]);
})->name('public.ekstrakurikuler.show');

Route::get('/informasi', fn () => view('public.informasi'))->name('public.informasi');
Route::get('/ppdb', function () {
    return view('public.ppdb', ['ppdb' => \App\Models\PpdbInformation::current()]);
})->name('public.ppdb');

Route::get('/siadik', function () {
    return view('public.siadik', ['siadik' => \App\Models\SiadikInformation::current()]);
})->name('public.siadik');
Route::get('/download', function () {
    return view('public.download', [
        'items' => \App\Models\Dokumen::where('status_publik', true)->orderByDesc('id')->get(),
    ]);
})->name('public.download')->middleware('throttle:30,1');

Route::get('/keuangan', function () {
    return view('public.keuangan', [
        'items' => \App\Models\LaporanKeuangan::publik()->orderByDesc('tanggal')->get(),
    ]);
})->name('public.keuangan');

Route::get('/kontak', function () {
    return view('public.kontak', ['pengaturan' => \App\Models\PengaturanSitus::current()]);
})->name('public.kontak');

Route::get('/sitemap.xml', function () {
    $urls = collect([
        ['loc' => route('home'), 'priority' => '1.0'],
        ['loc' => route('public.profil'), 'priority' => '0.8'],
        ['loc' => route('public.akademik'), 'priority' => '0.8'],
        ['loc' => route('public.berita'), 'priority' => '0.8'],
        ['loc' => route('public.prestasi'), 'priority' => '0.7'],
        ['loc' => route('public.ekstrakurikuler'), 'priority' => '0.7'],
        ['loc' => route('public.agenda'), 'priority' => '0.6'],
        ['loc' => route('public.galeri'), 'priority' => '0.6'],
        ['loc' => route('public.ppdb'), 'priority' => '0.9'],
        ['loc' => route('public.siadik'), 'priority' => '0.9'],
        ['loc' => route('public.faq'), 'priority' => '0.6'],
        ['loc' => route('public.kontak'), 'priority' => '0.5'],
    ]);

    return \Illuminate\Support\Facades\Cache::remember('sitemap-xml', 3600, function () use ($urls) {
        \App\Models\Berita::where('status', 'published')->select('slug')->limit(1000)
            ->each(fn ($b) => $urls->push(['loc' => route('public.berita.show', $b->slug), 'priority' => '0.6']));

        \App\Models\Prestasi::select('id')->limit(1000)
            ->each(fn ($p) => $urls->push(['loc' => route('public.prestasi.show', $p->id), 'priority' => '0.5']));

        \App\Models\Kompetensi::where('aktif', true)->select('slug')->limit(1000)
            ->each(fn ($k) => $urls->push(['loc' => route('public.akademik.show', $k->slug), 'priority' => '0.6']));

        \App\Models\Ekstrakurikuler::where('aktif', true)->select('id')->limit(1000)
            ->each(fn ($e) => $urls->push(['loc' => route('public.ekstrakurikuler.show', $e->id), 'priority' => '0.5']));

        return response()->view('sitemap', compact('urls'))->header('Content-Type', 'text/xml');
    });
})->name('sitemap');

Route::get('/faq', function () {
    $faqList = \App\Models\Faq::where('aktif', true)->orderBy('kategori')->orderBy('urutan')->get()->groupBy('kategori');
    return view('public.faq', compact('faqList'));
})->name('public.faq');

Route::get('/galeri', fn () => view('public.galeri'))->name('public.galeri');

Route::get('/cari', function () {
    $q = trim((string) request('q'));

    $berita = $q ? \App\Models\Berita::where('status', 'published')
        ->where(fn ($w) => $w->where('judul', 'like', "%{$q}%")->orWhere('ringkasan', 'like', "%{$q}%"))
        ->orderByDesc('tanggal_publikasi')->limit(10)->get() : collect();

    $prestasi = $q ? \App\Models\Prestasi::where('judul', 'like', "%{$q}%")
        ->orderByDesc('tahun')->limit(10)->get() : collect();

    $agenda = $q ? \App\Models\Agenda::where('judul', 'like', "%{$q}%")
        ->orderByDesc('tanggal')->limit(10)->get() : collect();

    $kompetensi = $q ? \App\Models\Kompetensi::where('aktif', true)->where('nama', 'like', "%{$q}%")->limit(10)->get() : collect();

    return view('public.search', compact('q', 'berita', 'prestasi', 'agenda', 'kompetensi'));
})->name('public.search')->middleware('throttle:10,1');
Route::get('/prestasi', fn () => view('public.prestasi'))->name('public.prestasi');
Route::get('/prestasi/{id}', function ($id) {
    return view('public.prestasi-show', [
        'item' => \App\Models\Prestasi::with(['siswa', 'kompetensi'])->findOrFail($id),
    ]);
})->name('public.prestasi.show');
Route::get('/agenda', fn () => view('public.agenda'))->name('public.agenda');
Route::get('/agenda/{id}', fn ($id) => view('public.agenda-show', [
    'agenda' => \App\Models\Agenda::findOrFail($id),
]))->name('public.agenda.show');

Route::middleware('auth')->group(function () {
    Route::get('/2fa/verify', fn () => view('auth.verify-two-factor'))->name('2fa.verify');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (in_array($user->role, ['admin', 'kepala_sekolah', 'jurnalistik'])) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'siswa') {
        return redirect()->route('siswa.dashboard');
    }

    return redirect()->route('guru.dashboard');
})->middleware('auth')->name('dashboard');

Route::prefix('guru')->name('guru.')->group(function () {
    Route::get('/portal-akses', fn () => view('guru.login'))->name('login');

    Route::middleware(['auth', 'role:guru'])->group(function () {
        Route::get('/dashboard', fn () => view('guru.dashboard'))->name('dashboard');
        Route::get('/absensi', fn () => view('guru.absensi'))->name('absensi');
        Route::get('/jadwal', fn () => view('guru.jadwal'))->name('jadwal');
        Route::get('/laporan', fn () => view('guru.laporan'))->name('laporan');
        Route::get('/profil', fn () => view('guru.profil'))->name('profil');
        Route::get('/wali-kelas', fn () => view('guru.wali-kelas'))->name('wali-kelas');
        Route::get('/riwayat-absensi', fn () => view('guru.riwayat-absensi'))->name('riwayat-absensi');
        });
});

Route::prefix('portal-siswa')->name('siswa.')->group(function () {
    Route::get('/portal-akses', fn () => view('siswa.login'))->name('login');

    Route::middleware(['auth', 'role:siswa'])->group(function () {
        Route::get('/dashboard', function () {
            $siswa = \App\Models\Siswa::with(['kelas', 'kompetensi'])
                ->where('user_id', auth()->id())->firstOrFail();

            $hariIni = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][now()->dayOfWeek];
            [$mulaiSemester, $selesaiSemester] = \App\Support\TahunAjaran::semesterBerjalan();

            return view('siswa.dashboard', [
                'siswa' => $siswa,
                'rekapAbsensi' => \App\Models\Absensi::where('siswa_id', $siswa->id)
                    ->whereHas('sesiMengajar', fn ($q) => $q->whereBetween('tanggal', [
                        $mulaiSemester->toDateString(), $selesaiSemester->toDateString(),
                    ]))
                    ->selectRaw('status, count(*) as jumlah')->groupBy('status')->pluck('jumlah', 'status'),
                'jadwalHariIni' => \App\Models\JadwalPelajaran::where('kelas_id', $siswa->kelas_id)
                    ->where('hari', $hariIni)->where('aktif', true)
                    ->with(['mataPelajaran', 'guru'])->orderBy('jam_mulai')->get(),
                'hariIni' => $hariIni,
                'prestasiTerbaru' => $siswa->prestasi()->latest('tahun')->limit(3)->get(),
            ]);
        })->name('dashboard');

        Route::get('/jadwal', function () {
            $siswa = \App\Models\Siswa::where('user_id', auth()->id())->firstOrFail();

            $jadwal = \App\Models\JadwalPelajaran::where('kelas_id', $siswa->kelas_id)
                ->where('aktif', true)
                ->with(['mataPelajaran', 'guru'])
                ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('hari');

            return view('siswa.jadwal', ['jadwal' => $jadwal]);
        })->name('jadwal');

        Route::get('/kehadiran', function () {
            $siswa = \App\Models\Siswa::where('user_id', auth()->id())->firstOrFail();
            [$mulaiSemester, $selesaiSemester] = \App\Support\TahunAjaran::semesterBerjalan();

            return view('siswa.kehadiran', [
                'rekapAbsensi' => \App\Models\Absensi::where('siswa_id', $siswa->id)
                    ->whereHas('sesiMengajar', fn ($q) => $q->whereBetween('tanggal', [
                        $mulaiSemester->toDateString(), $selesaiSemester->toDateString(),
                    ]))
                    ->selectRaw('status, count(*) as jumlah')->groupBy('status')->pluck('jumlah', 'status'),
                'riwayatAbsensi' => \App\Models\Absensi::where('siswa_id', $siswa->id)
                    ->whereHas('sesiMengajar', fn ($q) => $q->whereBetween('tanggal', [
                        $mulaiSemester->toDateString(), $selesaiSemester->toDateString(),
                    ]))
                    ->with('sesiMengajar.mataPelajaran')
                    ->latest('id')->paginate(20),
            ]);
        })->name('kehadiran');

        Route::get('/prestasi', function () {
            $siswa = \App\Models\Siswa::with(['prestasi' => fn ($q) => $q->orderByDesc('tahun'), 'ekstraWajib', 'ekstraPilihan'])
                ->where('user_id', auth()->id())->firstOrFail();

            return view('siswa.prestasi', ['siswa' => $siswa]);
        })->name('prestasi');

        Route::get('/pengaturan', fn () => view('siswa.pengaturan'))->name('pengaturan');
    });
});

Route::prefix('portal-manajemen')->name('admin.')->middleware(['auth', 'role:admin,kepala_sekolah,jurnalistik', 'verified.2fa', 'batasi.jurnalistik'])->group(function () {
    Route::get('/dashboard', fn () => auth()->user()->role === 'jurnalistik' ? view('admin.dashboard-jurnalistik') : view('admin.dashboard'))->name('dashboard');
    Route::get('/kompetensi', fn () => view('admin.kompetensi'))->name('kompetensi');
    Route::get('/alumni', fn () => view('admin.alumni'))->name('alumni');
    Route::get('/faq', fn () => view('admin.faq'))->name('faq');
    Route::get('/pengumuman-guru', fn () => view('admin.pengumuman-guru'))->name('pengumuman-guru');
    Route::get('/kelas', fn () => view('admin.kelas'))->name('kelas');
    Route::get('/guru', fn () => view('admin.guru'))->name('guru');
    Route::get('/siswa', fn () => view('admin.siswa'))->name('siswa');
    Route::get('/absensi', fn () => view('admin.absensi'))->name('absensi');
    Route::get('/hari-khusus', fn () => view('admin.hari-khusus'))->name('hari-khusus');
    Route::get('/berita', fn () => view('admin.berita'))->name('berita');
    Route::get('/mata-pelajaran', fn () => view('admin.mata-pelajaran'))->name('mata-pelajaran');
    Route::get('/jadwal-pelajaran', fn () => view('admin.jadwal-pelajaran'))->name('jadwal-pelajaran');
    Route::get('/jadwal-pengganti', fn () => view('admin.jadwal-pengganti'))->name('jadwal-pengganti');
    Route::get('/galeri', fn () => view('admin.galeri'))->name('galeri');
    Route::get('/prestasi', fn () => view('admin.prestasi'))->name('prestasi');
    Route::get('/agenda', fn () => view('admin.agenda'))->name('agenda');
    Route::get('/pengaturan', fn () => view('admin.pengaturan'))->name('pengaturan');
    Route::get('/ekstrakurikuler', fn () => view('admin.ekstrakurikuler'))->name('ekstrakurikuler');
    Route::get('/dokumen', fn () => view('admin.dokumen'))->name('dokumen');
    Route::get('/keuangan', fn () => view('admin.keuangan'))->name('keuangan');
    Route::get('/profil-sekolah', fn () => view('admin.profil-sekolah'))->name('profil-sekolah');
    Route::get('/hero-slider', fn () => view('admin.hero-slider'))->name('hero-slider');
    Route::get('/pengumuman', fn () => view('admin.pengumuman'))->name('pengumuman');
    Route::get('/statistik-sekolah', fn () => view('admin.statistik-sekolah'))->name('statistik-sekolah');
    Route::get('/ppdb', fn () => view('admin.ppdb'))->name('ppdb');
    Route::get('/siadik', fn () => view('admin.siadik'))->name('siadik');
    Route::get('/menu-navigasi', fn () => view('admin.menu-navigasi'))->name('menu-navigasi');
    Route::get('/activity-log', fn () => view('admin.activity-log'))->name('activity-log');
    Route::get('/login-log', fn () => view('admin.login-log'))->name('login-log');
    Route::middleware('role:admin')->group(function () {
    Route::get('/kelola-akun', fn () => view('admin.user'))->name('user');
    Route::get('/kenaikan-kelas', fn () => view('admin.kenaikan-kelas'))->name('kenaikan-kelas');
    Route::get('/backup-monitoring', fn () => view('admin.backup-monitoring'))->name('backup-monitoring');
    });

    Route::get('/cetak/siswa', fn () => view('admin.cetak.siswa'))->name('cetak.siswa');
    Route::get('/cetak/guru', fn () => view('admin.cetak.guru'))->name('cetak.guru');
    Route::get('/cetak/kartu-akses', fn () => view('admin.cetak.kartu-akses', [
        'kelasFilter' => request('kelas'),
        'kelasList' => \App\Models\Kelas::orderBy('nama_kelas')->get(),
    ]))->name('cetak.kartu-akses');
    Route::get('/absensi/export', function () {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AbsensiExport(request('kelas'), request('guru'), request('mulai'), request('selesai')),
            'rekap-absensi.xlsx'
        );
    })->name('absensi.export');
});

require __DIR__.'/auth.php';