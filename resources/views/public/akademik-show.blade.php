<x-layouts.public :title="$kompetensi->nama" :description="$kompetensi->profil_singkat ? Str::limit(strip_tags($kompetensi->profil_singkat), 150) : null" :image="$kompetensi->foto ? asset('storage/'.$kompetensi->foto) : null">
    <!-- HERO JURUSAN -->
    <section class="relative bg-navy text-white overflow-hidden min-h-[62vh] flex items-end pb-20">
        @if($kompetensi->foto)
            <img src="{{ asset('storage/'.$kompetensi->foto) }}" class="absolute inset-0 w-full h-full object-cover opacity-100 animate-hero-zoom">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/15"></div>
        <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-black/75 via-black/35 to-transparent pointer-events-none"></div>
        <div class="absolute -top-16 -left-16 w-72 h-72 bg-accent-teal/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-blue/15 rounded-full blur-3xl animate-blob" style="animation-delay:2s"></div>

        <div class="relative max-w-[900px] mx-auto px-4 text-center w-full">
            <a href="{{ route('public.akademik') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-white/80 hover:text-white bg-white/10 hover:bg-white/15 border border-white/15 px-3.5 py-1.5 rounded-full mb-8 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Akademik
            </a>
            <p class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[0.18em] uppercase text-white/90 justify-center">Kompetensi Keahlian</p>
            <h1 class="h-hero text-white mt-2" style="text-shadow: 0 2px 20px rgba(0,0,0,0.35)">{{ $kompetensi->nama }}</h1>
            <div class="w-14 h-1 bg-emerald-500 rounded-full mx-auto mt-5"></div>
        </div>
    </section>

    <div class="max-w-[900px] mx-auto px-4">
        <nav class="text-xs pt-6 flex items-center gap-1.5 flex-wrap">
            <a href="{{ route('home') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Beranda</a>
            <span class="text-[#C7CBD1]">/</span>
            <a href="{{ route('public.akademik') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Akademik</a>
            <span class="text-[#C7CBD1]">/</span>
            <span class="text-[#667085] line-clamp-1">{{ $kompetensi->nama }}</span>
        </nav>

        <!-- KARTU RINGKASAN MENGAMBANG -->
        <div class="relative -mt-14 mb-4">
            <div class="bg-white rounded-2xl shadow-2xl border border-[#EDEEF0] p-6 flex flex-wrap gap-6 justify-around text-center">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 4a4 4 0 100 8 4 4 0 000-8zM4 20c0-3.3 3.6-6 8-6s8 2.7 8 6"/></svg>
                    </div>
                    <p class="text-xl font-extrabold text-navy">{{ $kompetensi->siswa->count() }}</p>
                    <p class="text-xs text-[#667085]">Siswa Aktif</p>
                </div>
                @if($kompetensi->kepala_jurusan_nama)
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2-8 4.5V21h16v-2.5c0-2.5-3.6-4.5-8-4.5z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-navy">{{ $kompetensi->kepala_jurusan_nama }}</p>
                        <p class="text-xs text-[#667085]">Kepala Jurusan</p>
                    </div>
                @endif
                <div>
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5 2a9.5 9.5 0 11-19 0 9.5 9.5 0 0119 0z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-navy">SMK Fadlun Nafis</p>
                    <p class="text-xs text-[#667085]">Bangsri, Jepara</p>
                </div>
            </div>
        </div>

        <div class="py-10 space-y-10">
            <!-- PROFIL SINGKAT -->
            @if($kompetensi->profil_singkat)
                <div class="card-premium p-8 hover:-translate-y-0">
                    <p class="h-eyebrow">Tentang</p>
                    <h2 class="h-sub mb-4">Profil Singkat</h2>
                    <p class="h-body">{{ $kompetensi->profil_singkat }}</p>
                </div>
            @elseif($kompetensi->deskripsi)
                <div class="card-premium p-8 hover:-translate-y-0">
                    <p class="h-body">{{ $kompetensi->deskripsi }}</p>
                </div>
            @endif

            <!-- VISI MISI -->
            @if($kompetensi->visi || $kompetensi->misi)
                <div class="grid md:grid-cols-2 gap-6">
                    @if($kompetensi->visi)
                        <div class="card-premium p-7 hover:-translate-y-0">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/><path stroke="currentColor" stroke-width="1.5" d="M12 15a3 3 0 100-6 3 3 0 000 6z"/></svg>
                            </div>
                            <h3 class="h-sub mb-2">Visi</h3>
                            <p class="h-body">{{ $kompetensi->visi }}</p>
                        </div>
                    @endif
                    @if($kompetensi->misi)
                        <div class="card-premium p-7 hover:-translate-y-0">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5 2a9.5 9.5 0 11-19 0 9.5 9.5 0 0119 0z"/></svg>
                            </div>
                            <h3 class="h-sub mb-2">Misi</h3>
                            <div class="h-body space-y-1.5">
                                @foreach(preg_split('/\r\n|\r|\n/', $kompetensi->misi) as $baris)
                                    @if(trim($baris))
                                        <div class="flex items-start gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-accent-blue mt-2 flex-shrink-0"></span>
                                            <span>{{ trim($baris, "- ") }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- KEPALA JURUSAN -->
            @if($kompetensi->kepala_jurusan_nama)
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy to-navy-dark p-8 flex items-center gap-6">
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-accent-teal/15 rounded-full blur-3xl"></div>
                    @if($kompetensi->kepala_jurusan_foto)
                        <img src="{{ asset('storage/'.$kompetensi->kepala_jurusan_foto) }}" class="relative w-24 h-24 rounded-full object-cover ring-4 ring-white/20 flex-shrink-0">
                    @else
                        <div class="relative w-24 h-24 rounded-full bg-gradient-to-br from-accent-blue to-accent-teal text-white flex items-center justify-center text-3xl font-bold ring-4 ring-white/20 flex-shrink-0">
                            {{ substr($kompetensi->kepala_jurusan_nama, 0, 1) }}
                        </div>
                    @endif
                    <div class="relative">
                        <p class="text-xs font-bold tracking-[0.18em] uppercase text-accent-teal mb-1">Kepala Jurusan</p>
                        <h3 class="text-xl font-bold text-white">{{ $kompetensi->kepala_jurusan_nama }}</h3>
                        <p class="text-sm text-white/60">{{ $kompetensi->kepala_jurusan_jabatan ?? 'Kepala Kompetensi Keahlian' }}</p>
                    </div>
                </div>
            @endif

            <!-- PROSPEK KARIR -->
            @if($kompetensi->prospek_karir)
                <div class="card-premium p-8 hover:-translate-y-0">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M20 7h-9m9 5h-9m9 5h-9M4 7h1v1H4V7zm0 5h1v1H4v-1zm0 5h1v1H4v-1z"/></svg>
                    </div>
                    <p class="h-eyebrow">Setelah Lulus</p>
                    <h2 class="h-sub mb-4">Prospek Karir Lulusan</h2>
                    <div class="h-body space-y-1.5">
                        @foreach(preg_split('/\r\n|\r|\n/', $kompetensi->prospek_karir) as $baris)
                            @if(trim($baris))
                                <div class="flex items-start gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-accent-blue mt-2 flex-shrink-0"></span>
                                    <span>{{ trim($baris, "- ") }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- TESTIMONI ALUMNI -->
            @php $alumniList = \App\Models\Alumni::where('kompetensi_id', $kompetensi->id)->where('aktif', true)->orderByDesc('id')->get(); @endphp
            @if($alumniList->count())
                <div>
                    <p class="h-eyebrow">Bukti Nyata</p>
                    <h2 class="h-sub mb-5">Kata Alumni</h2>
                    <div class="grid md:grid-cols-2 gap-5">
                        @foreach($alumniList as $al)
                            <div class="card-premium p-6 hover:-translate-y-0">
                                <svg class="w-7 h-7 text-accent-blue/25 mb-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9.5 4C6 4 3 7.5 3 12.5c0 3.6 2.2 6 5 6 2 0 3.5-1.5 3.5-3.5S10 12 8.5 12c-.4 0-.7 0-1 .1.3-2.4 2-4.5 4.5-5.3L11 4.5C10.5 4.2 10 4 9.5 4zm10 0c-3.5 0-6.5 3.5-6.5 8.5 0 3.6 2.2 6 5 6 2 0 3.5-1.5 3.5-3.5s-1.5-3-3-3c-.4 0-.7 0-1 .1.3-2.4 2-4.5 4.5-5.3L21 4.5c-.5-.3-1-.5-1.5-.5z"/></svg>
                                @if($al->testimoni)
                                    <p class="h-body italic mb-4">&ldquo;{{ $al->testimoni }}&rdquo;</p>
                                @endif
                                <div class="flex items-center gap-3">
                                    @if($al->foto)
                                        <img src="{{ asset('storage/'.$al->foto) }}" class="w-11 h-11 rounded-full object-cover flex-shrink-0">
                                    @else
                                        <div class="w-11 h-11 rounded-full bg-navy text-white flex items-center justify-center font-bold flex-shrink-0">{{ substr($al->nama, 0, 1) }}</div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-bold text-navy">{{ $al->nama }}</p>
                                        <p class="text-xs text-[#667085]">{{ $al->pekerjaan_sekarang ?: 'Alumni' }}@if($al->tahun_lulus) &middot; Lulus {{ $al->tahun_lulus }} @endif</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- GALERI KEGIATAN -->
            @php $fotoKegiatan = collect([$kompetensi->foto_kegiatan_1, $kompetensi->foto_kegiatan_2, $kompetensi->foto_kegiatan_3])->filter(); @endphp
            @if($fotoKegiatan->count())
                <div>
                    <p class="h-eyebrow">Dokumentasi</p>
                    <h2 class="h-sub mb-5">Kegiatan & Praktik</h2>
                    <div class="grid {{ $fotoKegiatan->count() >= 3 ? 'grid-cols-2 sm:grid-cols-3' : ($fotoKegiatan->count() === 2 ? 'grid-cols-2' : 'grid-cols-1 max-w-sm') }} gap-4">
                        @foreach($fotoKegiatan as $foto)
                            <a href="{{ asset('storage/'.$foto) }}" target="_blank" class="group relative rounded-2xl overflow-hidden aspect-[4/3] shadow-sm hover:shadow-lg transition-shadow block">
                                <img src="{{ asset('storage/'.$foto) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        
        <div class="flex items-center gap-3 mb-6">
            <span class="text-sm font-medium text-[#667085]">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($kompetensi->nama.' - '.url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-green-50 hover:bg-green-100 flex items-center justify-center text-green-600 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.79 14.08c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.98 0-1.42.74-2.11 1-2.4.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.58.81 2 .88 2.14.07.15.11.32.02.51-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.27.37-.22.62-.13.25.09 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-accent-blue transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z"/></svg>
            </a>
        </div>
        <!-- KOMPETENSI LAIN -->
        @php $kompetensiLain = \App\Models\Kompetensi::where('aktif', true)->where('id', '!=', $kompetensi->id)->get(); @endphp
        @if($kompetensiLain->count())
            <div class="pb-16">
                <p class="h-eyebrow">Jelajahi Lebih Lanjut</p>
                <h2 class="h-sub mb-5">Kompetensi Keahlian Lainnya</h2>
                <div class="grid md:grid-cols-2 gap-5">
                    @foreach($kompetensiLain as $k)
                        <a href="{{ route('public.akademik.show', $k->slug) }}" class="group card-premium p-6 flex items-center gap-4">
                            @if($k->foto)
                                <img src="{{ asset('storage/'.$k->foto) }}" class="w-14 h-14 rounded-full object-cover flex-shrink-0 ring-4 ring-light-blue">
                            @else
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-accent-blue to-accent-teal text-white flex items-center justify-center flex-shrink-0 font-bold ring-4 ring-light-blue">
                                    {{ substr($k->nama, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-navy group-hover:text-accent-blue transition-colors">{{ $k->nama }}</p>
                                <p class="text-xs text-[#667085] mt-1">Lihat detail →</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.public>