<x-layouts.siswa>
    <h1 class="h-section mb-6">Prestasi & Ekstrakurikuler</h1>

    <h3 class="h-sub mb-3">Prestasi</h3>
    <div class="card-premium overflow-hidden mb-8">
        @forelse($siswa->prestasi as $p)
            <div class="p-4 flex justify-between items-center {{ !$loop->last ? 'border-b border-[#E5E7EB]' : '' }}">
                <div>
                    <p class="font-semibold text-sm text-navy">{{ $p->judul }}</p>
                    @if($p->tingkat)
                        <p class="text-xs text-[#667085] mt-0.5">{{ $p->tingkat }}</p>
                    @endif
                </div>
                <span class="text-xs text-[#98A2B3] flex-shrink-0 ml-4">{{ $p->tahun }}</span>
            </div>
        @empty
            <p class="p-6 text-center text-sm text-[#98A2B3]">Belum ada prestasi yang tercatat.</p>
        @endforelse
    </div>

    <h3 class="h-sub mb-3">Ekstrakurikuler Wajib</h3>
    <div class="card-premium overflow-hidden mb-8">
        @forelse($siswa->ekstraWajib as $e)
            <div class="p-4 {{ !$loop->last ? 'border-b border-[#E5E7EB]' : '' }}">
                <p class="font-semibold text-sm text-navy">{{ $e->nama }}</p>
            </div>
        @empty
            <p class="p-6 text-center text-sm text-[#98A2B3]">Belum terdaftar di ekstrakurikuler wajib.</p>
        @endforelse
    </div>

    <h3 class="h-sub mb-3">Ekstrakurikuler Pilihan</h3>
    <div class="card-premium overflow-hidden">
        @forelse($siswa->ekstraPilihan as $e)
            <div class="p-4 {{ !$loop->last ? 'border-b border-[#E5E7EB]' : '' }}">
                <p class="font-semibold text-sm text-navy">{{ $e->nama }}</p>
            </div>
        @empty
            <p class="p-6 text-center text-sm text-[#98A2B3]">Belum terdaftar di ekstrakurikuler pilihan.</p>
        @endforelse
    </div>
</x-layouts.siswa>