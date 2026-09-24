<x-layouts.public title="FAQ" description="Pertanyaan yang sering diajukan seputar SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Pusat Bantuan" title="Pertanyaan Umum" subtitle="Jawaban cepat untuk pertanyaan yang sering ditanyakan." />

    <div class="max-w-[800px] mx-auto px-4 py-14">
        @forelse($faqList as $kategori => $daftar)
            <div class="mb-10" data-reveal>
                <p class="h-eyebrow">{{ $kategori }}</p>
                <h2 class="h-sub mb-4">Seputar {{ $kategori }}</h2>
                <div class="space-y-3">
                    @foreach($daftar as $f)
                        <div x-data="{ open: false }" class="card-premium hover:-translate-y-0 overflow-hidden">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between gap-4 p-5 text-left">
                                <span class="font-semibold text-navy text-sm">{{ $f->pertanyaan }}</span>
                                <svg class="w-4 h-4 text-[#667085] flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-cloak x-transition class="px-5 pb-5 text-sm h-body">
                                {{ $f->jawaban }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-16 text-[#667085]">Belum ada FAQ tersedia.</div>
        @endforelse

        <div class="card-premium hover:-translate-y-0 p-6 text-center mt-8">
            <p class="text-sm text-navy font-semibold mb-1">Masih ada pertanyaan lain?</p>
            <p class="text-sm text-[#667085] mb-4">Tim kami siap membantu lewat WhatsApp atau halaman kontak.</p>
            <a href="{{ route('public.kontak') }}" class="btn-primary">Hubungi Kami</a>
        </div>
    </div>
</x-layouts.public>