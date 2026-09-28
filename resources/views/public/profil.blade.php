<x-layouts.public title="Profil Sekolah" description="Sejarah, visi misi, dan profil lengkap SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Tentang Kami" title="Profil Sekolah" subtitle="Mengenal lebih dekat SMK Fadlun Nafis Bangsri — sejarah, visi misi, dan tenaga pendidik kami." />

    <div class="max-w-[900px] mx-auto px-4 py-16">
        @if($profil->profil)
            <div class="relative bg-white border border-[#EDEEF0] rounded-2xl p-7 mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-lg bg-[#F4FBF7] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="font-bold text-navy text-lg">Profil Sekolah</h2>
                </div>
                <p class="text-navy text-sm leading-relaxed whitespace-pre-line">{{ $profil->profil }}</p>
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