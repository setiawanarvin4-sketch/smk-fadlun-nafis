<x-layouts.public title="Laporan Keuangan" description="Transparansi laporan keuangan SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Transparansi" title="Laporan Keuangan" subtitle="Transparansi laporan keuangan SMK Fadlun Nafis Bangsri" />
    <div class="max-w-[800px] mx-auto px-4 py-14">

        <div class="bg-white border border-[#E5E7EB] rounded-xl divide-y divide-[#E5E7EB]">
            @forelse($items as $item)
                <div class="p-4 flex justify-between items-center hover:bg-[#F6F7FA] transition-colors">
                    <div>
                        <p class="font-medium">{{ $item->judul }}</p>
                        <p class="text-xs text-[#667085]">{{ $item->tanggal?->translatedFormat('d F Y') }}</p>
                    </div>
                    <a href="{{ asset('storage/'.$item->file) }}" target="_blank" class="text-accent-blue text-sm font-medium">Lihat →</a>
                </div>
            @empty
                <p class="text-[#667085] text-center py-14">Belum ada laporan keuangan publik.</p>
            @endforelse
        </div>
    </div>
</x-layouts.public>