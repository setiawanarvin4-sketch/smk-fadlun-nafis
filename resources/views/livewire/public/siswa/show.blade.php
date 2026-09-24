<div class="max-w-[700px] mx-auto px-4 py-14">
    <nav class="text-xs mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Beranda</a>
        <span class="text-[#C7CBD1]">/</span>
        <a href="{{ route('public.siswa') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Siswa Berprestasi</a>
        <span class="text-[#C7CBD1]">/</span>
        <span class="text-[#667085] line-clamp-1">{{ $siswa->nama }}</span>
    </nav>

    <a href="{{ route('public.siswa') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-navy bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue border border-[#E5E7EB] px-3.5 py-1.5 rounded-full mb-2 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Siswa Berprestasi
    </a>

    <div class="card-premium hover:-translate-y-0 p-6 mt-6 text-center">
        @if($siswa->foto)
            <img src="{{ asset('storage/'.$siswa->foto) }}" class="w-28 h-28 rounded-full object-cover mx-auto mb-4">
        @else
            <div class="w-28 h-28 rounded-full bg-light-blue text-accent-blue flex items-center justify-center mx-auto mb-4 text-3xl font-semibold">
                {{ substr($siswa->nama, 0, 1) }}
            </div>
        @endif
        <h1 class="text-2xl font-semibold text-navy">{{ $siswa->nama }}</h1>
        <p class="text-[#667085]">{{ $siswa->kelas->nama_kelas ?? '-' }} · {{ $siswa->kompetensi->nama ?? '-' }}</p>
    </div>

    @if($siswa->prestasi->count())
        <div class="mt-8">
            <p class="text-xs font-semibold tracking-widest uppercase text-accent-blue mb-1.5">Kebanggaan</p>
            <h2 class="font-semibold text-lg text-navy mb-4">Prestasi</h2>
            <div class="space-y-3">
                @foreach($siswa->prestasi as $p)
                    <div class="bg-white border border-[#E5E7EB] rounded-xl p-4 hover:shadow-md transition-shadow">
                        <p class="font-medium">{{ $p->judul }}</p>
                        <p class="text-sm text-[#667085]">{{ $p->kategori }} · {{ $p->tingkat }} · {{ $p->tahun }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
        @if($siswa->ekstraWajib->count() || $siswa->ekstraPilihan->count())
        <div class="mt-8">
            <p class="text-xs font-semibold tracking-widest uppercase text-accent-blue mb-1.5">Kegiatan</p>
            <h2 class="font-semibold text-lg text-navy mb-4">Ekstrakurikuler</h2>
            <div class="space-y-3">
                @if($siswa->ekstraWajib->count())
                    <div class="bg-white border border-[#E5E7EB] rounded-xl p-4">
                        <p class="text-xs font-semibold text-[#667085] mb-2">Wajib</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($siswa->ekstraWajib as $e)
                                <span class="px-2.5 py-1 rounded-full bg-light-blue text-accent-blue text-xs font-medium">{{ $e->nama }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if($siswa->ekstraPilihan->count())
                    <div class="bg-white border border-[#E5E7EB] rounded-xl p-4">
                        <p class="text-xs font-semibold text-[#667085] mb-2">Pilihan</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($siswa->ekstraPilihan as $e)
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">{{ $e->nama }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>