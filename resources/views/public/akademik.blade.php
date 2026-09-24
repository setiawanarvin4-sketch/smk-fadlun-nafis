<x-layouts.public title="Akademik" description="Program keahlian yang tersedia di SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Program Keahlian" title="Akademik" subtitle="Kompetensi keahlian yang tersedia di SMK Fadlun Nafis Bangsri" />
    <div class="max-w-[1100px] mx-auto px-4 py-14">

        <div class="grid md:grid-cols-2 gap-6">
            @foreach($kompetensiList as $k)
                <a href="{{ route('public.akademik.show', $k->slug) }}" class="group bg-white border border-[#E5E7EB] rounded-xl p-6 flex gap-4 items-start hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    @if($k->foto)
                        <img src="{{ asset('storage/'.$k->foto) }}" class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                    @else
                        <div class="w-16 h-16 rounded-full bg-light-blue text-accent-blue flex items-center justify-center flex-shrink-0 font-bold text-lg">
                            {{ substr($k->nama, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-navy text-lg mb-2 group-hover:text-accent-blue transition-colors">{{ $k->nama }}</h3>
                        <p class="text-sm text-[#667085]">{{ $k->deskripsi }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.public>