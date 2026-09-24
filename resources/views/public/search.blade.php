<?php $totalHasil = $berita->count() + $prestasi->count() + $agenda->count() + $kompetensi->count(); ?>
<x-layouts.public title="Hasil Pencarian: {{ $q }}" description="Hasil pencarian untuk &quot;{{ $q }}&quot; di situs SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Pencarian" title="{{ $q ? 'Hasil untuk &quot;'.$q.'&quot;' : 'Cari' }}" :subtitle="$q ? $totalHasil.' hasil ditemukan' : 'Ketik kata kunci untuk mencari berita, prestasi, agenda, atau program keahlian'" />

    <div class="max-w-[900px] mx-auto px-4 py-14">
        <form action="{{ route('public.search') }}" method="GET" class="flex gap-2 mb-10">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari berita, prestasi, agenda, kompetensi..."
                class="flex-1 border border-[#E5E7EB] rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue">
            <button type="submit" class="btn-primary !px-6">Cari</button>
        </form>

        @if($q && $totalHasil === 0)
            <div class="text-center py-16">
                <p class="text-[#667085]">Tidak ada hasil untuk "<strong>{{ $q }}</strong>". Coba kata kunci lain.</p>
            </div>
        @endif

        @if($berita->count())
            <div class="mb-10">
                <p class="h-eyebrow">Berita</p>
                <h2 class="h-sub mb-4">Ditemukan {{ $berita->count() }} berita</h2>
                <div class="space-y-3">
                    @foreach($berita as $b)
                        <a href="{{ route('public.berita.show', $b->slug) }}" class="block card-premium p-4 hover:-translate-y-0">
                            <p class="font-bold text-navy">{{ $b->judul }}</p>
                            <p class="text-xs text-[#667085] mt-1">{{ $b->tanggal_publikasi?->translatedFormat('d M Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($prestasi->count())
            <div class="mb-10">
                <p class="h-eyebrow">Prestasi</p>
                <h2 class="h-sub mb-4">Ditemukan {{ $prestasi->count() }} prestasi</h2>
                <div class="space-y-3">
                    @foreach($prestasi as $p)
                        <a href="{{ route('public.prestasi.show', $p->id) }}" class="block card-premium p-4 hover:-translate-y-0">
                            <p class="font-bold text-navy">{{ $p->judul }}</p>
                            <p class="text-xs text-[#667085] mt-1">{{ $p->tingkat }} · {{ $p->tahun }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($agenda->count())
            <div class="mb-10">
                <p class="h-eyebrow">Agenda</p>
                <h2 class="h-sub mb-4">Ditemukan {{ $agenda->count() }} agenda</h2>
                <div class="space-y-3">
                    @foreach($agenda as $a)
                        <a href="{{ route('public.agenda.show', $a->id) }}" class="block card-premium p-4 hover:-translate-y-0">
                            <p class="font-bold text-navy">{{ $a->judul }}</p>
                            <p class="text-xs text-[#667085] mt-1">{{ $a->tanggal->translatedFormat('d M Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($kompetensi->count())
            <div class="mb-10">
                <p class="h-eyebrow">Program Keahlian</p>
                <h2 class="h-sub mb-4">Ditemukan {{ $kompetensi->count() }} kompetensi</h2>
                <div class="space-y-3">
                    @foreach($kompetensi as $k)
                        <a href="{{ route('public.akademik.show', $k->slug) }}" class="block card-premium p-4 hover:-translate-y-0">
                            <p class="font-bold text-navy">{{ $k->nama }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.public>