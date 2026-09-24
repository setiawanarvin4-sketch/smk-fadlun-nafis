<x-layouts.public :title="$agenda->judul" :description="$agenda->deskripsi ? Str::limit(strip_tags($agenda->deskripsi), 150) : null">
    <x-page-hero eyebrow="Agenda Sekolah" title="{{ $agenda->judul }}" />
    <div class="max-w-[800px] mx-auto px-4 py-14">
        <nav class="text-xs mb-4 flex items-center gap-1.5 flex-wrap" data-reveal>
            <a href="{{ route('home') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Beranda</a>
            <span class="text-[#C7CBD1]">/</span>
            <a href="{{ route('public.agenda') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Agenda</a>
            <span class="text-[#C7CBD1]">/</span>
            <span class="text-[#667085] line-clamp-1">{{ $agenda->judul }}</span>
        </nav>

        <a href="{{ route('public.agenda') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-navy bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue border border-[#E5E7EB] px-3.5 py-1.5 rounded-full mb-2 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Agenda
        </a>

        @if($agenda->foto)
            <img src="{{ asset('storage/'.$agenda->foto) }}" class="w-full h-64 md:h-80 object-cover rounded-xl mt-6">
        @endif

        <p class="text-xs font-semibold tracking-widest uppercase text-accent-blue mt-6 mb-2">
            {{ $agenda->tanggal->translatedFormat('d F Y') }}
        </p>
        <h1 class="text-2xl md:text-3xl font-bold text-navy leading-tight">{{ $agenda->judul }}</h1>

        <div class="flex flex-wrap gap-4 mt-4 text-sm text-[#667085]">
            @if($agenda->jam)
                <span>Pukul {{ substr($agenda->jam, 0, 5) }} WIB</span>
            @endif
            @if($agenda->lokasi)
                <span>Lokasi: {{ $agenda->lokasi }}</span>
            @endif
        </div>

        @if($agenda->deskripsi)
            <div class="prose prose-sm max-w-none mt-8 text-navy">
                {{ $agenda->deskripsi }}
            </div>
        @endif
    </div>
</x-layouts.public>