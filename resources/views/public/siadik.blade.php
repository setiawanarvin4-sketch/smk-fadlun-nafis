<x-layouts.public title="SiAdik" description="Informasi dan akses SiAdik — sistem akademik resmi SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Sistem Akademik Sekolah" title="SiAdik" subtitle="Portal akademik resmi untuk memudahkan siswa, orang tua, dan guru mengakses informasi sekolah kapan saja." />

    <div class="max-w-[900px] mx-auto px-4 py-14">

        {{-- NILAI LAYANAN --}}
        <div class="grid sm:grid-cols-3 gap-4 mb-10">
            <div class="card-premium hover:-translate-y-0 p-6">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-sm font-bold text-navy mb-1">Akses Kapan Saja</p>
                <p class="text-xs text-[#667085] leading-relaxed">Buka dari HP atau komputer, tanpa perlu datang ke sekolah.</p>
            </div>
            <div class="card-premium hover:-translate-y-0 p-6">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-sm font-bold text-navy mb-1">Data Resmi Sekolah</p>
                <p class="text-xs text-[#667085] leading-relaxed">Informasi akademik langsung dari sistem yang dikelola sekolah.</p>
            </div>
            <div class="card-premium hover:-translate-y-0 p-6">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-2.13a4 4 0 100-8 4 4 0 000 8zm6 0a4 4 0 100-8 4 4 0 000 8z"/></svg>
                </div>
                <p class="text-sm font-bold text-navy mb-1">Untuk Siswa & Orang Tua</p>
                <p class="text-xs text-[#667085] leading-relaxed">Satu portal yang bisa dipakai bersama untuk memantau perkembangan siswa.</p>
            </div>
        </div>

        {{-- DESKRIPSI --}}
        @if($siadik->deskripsi)
            <div class="card-premium hover:-translate-y-0 p-7 md:p-8 mb-10">
                <p class="h-eyebrow">Tentang SiAdik</p>
                <div class="prose prose-sm max-w-none mt-3 text-navy">{!! $siadik->deskripsi !!}</div>
            </div>
        @endif

        {{-- GALERI --}}
        @if(!empty($siadik->galeri))
            <p class="h-eyebrow">Tampilan</p>
            <h2 class="h-sub mb-5">Sekilas SiAdik</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-10">
                @foreach($siadik->galeri as $path)
                    <a href="{{ asset('storage/'.$path) }}" target="_blank" rel="noopener" class="group block overflow-hidden rounded-xl border border-[#E5E7EB]">
                        <img src="{{ asset('storage/'.$path) }}" alt="Tampilan SiAdik" loading="lazy" class="w-full h-32 sm:h-40 object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>
                @endforeach
            </div>
        @endif

        {{-- CTA --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy to-navy-dark text-white p-8 md:p-10 text-center">
            <div class="absolute -top-10 -right-10 w-56 h-56 bg-accent-teal/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-56 h-56 bg-accent-blue/20 rounded-full blur-3xl"></div>
            <div class="relative">
                <p class="h-eyebrow !text-white/70">Siap Digunakan</p>
                <h2 class="text-xl md:text-2xl font-bold mb-2">Buka SiAdik Sekarang</h2>
                <p class="text-white/70 text-sm max-w-md mx-auto mb-7">Anda akan diarahkan ke sistem SiAdik yang dikelola dan diakses secara terpisah dari situs ini.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ $siadik->url_siadik }}" target="_blank" rel="noopener"
                       class="flex items-center justify-center gap-2 bg-white text-navy text-sm font-bold px-7 py-3.5 rounded-xl shadow-lg w-full sm:w-auto hover:bg-light-blue transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        Buka SiAdik
                    </a>
                    <a href="{{ route('public.kontak') }}"
                       class="flex items-center justify-center gap-2 bg-white/10 hover:bg-white/15 border border-white/20 text-white text-sm font-semibold px-7 py-3.5 rounded-xl w-full sm:w-auto transition-colors">
                        Kendala Login? Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

        <p class="text-xs text-[#667085] mt-4 text-center">
            SiAdik dikelola dan diakses secara terpisah dari website ini — halaman ini hanya menampilkan
            informasi dan tautan aksesnya.
        </p>
    </div>
</x-layouts.public>