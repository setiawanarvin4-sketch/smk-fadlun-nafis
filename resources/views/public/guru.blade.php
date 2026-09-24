<x-layouts.public title="Guru & Tenaga Kependidikan" :description="''.$guruList->count().' tenaga pendidik dan kependidikan SMK Fadlun Nafis Bangsri.'">
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
        <div class="relative max-w-[1100px] mx-auto px-4 pt-32 pb-16 text-center">
            <p class="text-xs font-bold tracking-[0.18em] uppercase text-accent-blue mb-3">Sumber Daya</p>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-3 text-navy">Guru & Tenaga Kependidikan</h1>
            <div class="w-10 h-px bg-emerald-500 mx-auto mb-3"></div>
            <p class="text-[#667085] text-sm max-w-md mx-auto">{{ $guruList->count() }} tenaga pendidik dan kependidikan di SMK Fadlun Nafis Bangsri.</p>
        </div>
    </section>

    <div class="max-w-[1100px] mx-auto px-4 py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($guruList as $g)
                <div class="group bg-white border border-[#EDEEF0] rounded-2xl p-5 text-center hover:border-emerald-500/40 hover:shadow-lg transition-all duration-300">
                    @if($g->foto)
                        <img src="{{ asset('storage/'.$g->foto) }}" class="w-20 h-20 rounded-full object-cover mx-auto mb-3 ring-4 ring-[#F4FBF7] group-hover:ring-emerald-500/15 transition-all">
                    @else
                        <div class="w-20 h-20 rounded-full bg-navy text-white flex items-center justify-center mx-auto mb-3 text-xl font-bold ring-4 ring-[#F4FBF7]">
                            {{ substr($g->nama, 0, 1) }}
                        </div>
                    @endif
                    <p class="text-sm font-bold text-navy leading-snug">{{ $g->nama }}</p>
                    <p class="text-xs text-[#667085] mt-1">{{ $g->jabatan ?? 'Guru' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.public>