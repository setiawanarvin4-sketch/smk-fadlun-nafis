<x-layouts.public title="Guru & Tenaga Kependidikan" :description="''.$guruList->count().' tenaga pendidik dan kependidikan SMK Fadlun Nafis Bangsri.'">
    <x-page-hero eyebrow="Sumber Daya" title="Guru & Tenaga Kependidikan" :subtitle="$guruList->count().' tenaga pendidik dan kependidikan di SMK Fadlun Nafis Bangsri.'" />

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