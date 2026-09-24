<x-layouts.public title="Ekstrakurikuler" description="Kegiatan ekstrakurikuler SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Kegiatan Siswa" title="Ekstrakurikuler" subtitle="Kegiatan ekstrakurikuler SMK Fadlun Nafis Bangsri" />
    <div class="max-w-[1100px] mx-auto px-4 py-14">

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($items as $item)
                <a href="{{ route('public.ekstrakurikuler.show', $item->id) }}" class="group card-premium overflow-hidden">
                    <div class="overflow-hidden h-40">
                        @if($item->foto)
                            <img src="{{ asset('storage/'.$item->foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($item->nama, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-navy group-hover:text-accent-blue transition-colors">{{ $item->nama }}</h3>
                        @if($item->pembina)
                            <p class="text-xs text-[#667085] mt-1">Pembina: {{ $item->pembina }}</p>
                        @endif
                        @if($item->deskripsi)
                            <p class="text-sm h-body mt-2 line-clamp-2">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="card-premium col-span-3 text-center py-14 text-[#667085] hover:-translate-y-0">
                    Belum ada ekstrakurikuler.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.public>