<x-layouts.public title="Profil Sekolah" description="Sejarah, visi misi, dan profil lengkap SMK Fadlun Nafis Bangsri.">
    <!-- PAGE HEADER -->
    <section class="relative bg-[#F7F8FA] text-navy overflow-hidden border-b border-[#E5E7EB]">
        @if($profil->header_gambar)
            <img src="{{ asset('storage/'.$profil->header_gambar) }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/70 to-white/30"></div>
        @else
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-accent-teal/10 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-accent-blue/10 rounded-full blur-3xl animate-blob" style="animation-delay:2s"></div>
        @endif
        <div class="absolute top-8 left-4 right-4 md:left-10 md:right-10 flex justify-between pointer-events-none">
            <div class="w-8 h-8 border-t border-l border-navy/15"></div>
            <div class="w-8 h-8 border-t border-r border-navy/15"></div>
        </div>
        <div class="relative max-w-[900px] mx-auto px-4 pt-32 pb-16 text-center">
            <p class="text-xs font-bold tracking-[0.18em] uppercase text-accent-blue mb-3">Tentang Kami</p>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-3 text-navy">Profil Sekolah</h1>
            <div class="w-10 h-px bg-emerald-500 mx-auto mb-3"></div>
            <p class="text-[#667085] text-sm max-w-md mx-auto">Mengenal lebih dekat SMK Fadlun Nafis Bangsri — sejarah, visi misi, dan tenaga pendidik kami.</p>
        </div>
    </section>

    <div class="max-w-[900px] mx-auto px-4 py-16">
        @if($sambutan->isi)
            <div class="grid md:grid-cols-[0.8fr_1.2fr] gap-12 items-center mb-16">
                <div class="relative max-w-xs mx-auto md:mx-0">
                    <div class="absolute -top-4 -left-4 w-full h-full border-2 border-emerald-500/40 rounded-2xl -z-10"></div>
                    @if($sambutan->foto)
                        <img src="{{ asset('storage/'.$sambutan->foto) }}" class="w-full aspect-[3/4] object-cover rounded-2xl shadow-xl">
                    @else
                        <div class="w-full aspect-[3/4] rounded-2xl bg-navy text-white flex items-center justify-center text-5xl font-bold shadow-xl">
                            {{ substr($sambutan->nama ?? 'K', 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute left-5 -bottom-5 right-5 bg-white rounded-xl shadow-lg border border-[#EDEEF0] px-4 py-3">
                        <p class="font-bold text-navy text-sm leading-tight">{{ $sambutan->nama ?? 'Kepala Sekolah' }}</p>
                        <p class="text-xs text-[#667085] mt-0.5">{{ $sambutan->jabatan }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase text-accent-blue mb-2">Sambutan</p>
                    <h2 class="font-bold text-navy text-xl mb-4">{{ $sambutan->judul ?? 'Sambutan Kepala Sekolah' }}</h2>
                    <svg class="w-8 h-8 text-emerald-500/30 mb-1" fill="currentColor" viewBox="0 0 24 24"><path d="M9.5 4C6 4 3 7.5 3 12.5c0 3.6 2.2 6 5 6 2 0 3.5-1.5 3.5-3.5S10 12 8.5 12c-.4 0-.7 0-1 .1.3-2.4 2-4.5 4.5-5.3L11 4.5C10.5 4.2 10 4 9.5 4zm10 0c-3.5 0-6.5 3.5-6.5 8.5 0 3.6 2.2 6 5 6 2 0 3.5-1.5 3.5-3.5s-1.5-3-3-3c-.4 0-.7 0-1 .1.3-2.4 2-4.5 4.5-5.3L21 4.5c-.5-.3-1-.5-1.5-.5z"/></svg>
                    <div class="prose prose-sm max-w-none text-navy">{!! $sambutan->isi !!}</div>
                </div>
            </div>
        @endif

        @if($profil->sejarah)
            <div id="sejarah" class="relative bg-white border border-[#EDEEF0] rounded-2xl p-7 mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-lg bg-[#F4FBF7] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="font-bold text-navy text-lg">Sejarah</h2>
                </div>
                <div class="prose prose-sm max-w-none text-navy">{!! $profil->sejarah !!}</div>
            </div>
        @endif

        <div id="visi-misi" class="grid md:grid-cols-2 gap-6 mb-8">
            @if($profil->visi)
                <div class="relative bg-gradient-to-br from-navy to-navy-dark text-white rounded-2xl p-7 flex flex-col overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-accent-teal/10 rounded-full blur-3xl"></div>
                    <div class="relative w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/></svg>
                    </div>
                    <h3 class="relative font-bold text-sm uppercase tracking-widest text-white/60 mb-3">Visi</h3>
                    <p class="relative text-lg leading-relaxed font-medium italic">&ldquo;{{ $profil->visi }}&rdquo;</p>
                </div>
            @endif
            @if($profil->misi)
                <div class="bg-white border border-[#EDEEF0] rounded-2xl p-7">
                    <div class="w-9 h-9 rounded-lg bg-[#F4FBF7] flex items-center justify-center mb-4">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 12l2 2 4-4M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="font-bold text-sm uppercase tracking-widest text-[#667085] mb-3">Misi</h3>
                    <div class="prose prose-sm max-w-none text-navy marker:text-emerald-600">{!! $profil->misi !!}</div>
                </div>
            @endif
        </div>

        @if($profil->struktur_organisasi)
            <div id="struktur" class="bg-white border border-[#EDEEF0] rounded-2xl p-7 mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-lg bg-[#F4FBF7] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-5.13a4 4 0 100-8 4 4 0 000 8zm6 2a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    </div>
                    <h2 class="font-bold text-navy text-lg">Struktur Organisasi</h2>
                </div>
                <div class="prose prose-sm max-w-none text-navy">{!! $profil->struktur_organisasi !!}</div>
            </div>
        @endif
    </div>
</x-layouts.public>