<x-layouts.public title="Informasi" description="Pusat informasi SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Pusat Informasi" title="Informasi" />
    <div class="max-w-[900px] mx-auto px-4 py-14">
        <div class="grid md:grid-cols-2 gap-4">
            <a href="{{ route('public.berita') }}?kategori=Pengumuman" class="bg-white border border-[#E5E7EB] rounded-xl p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <p class="font-semibold text-navy">Pengumuman</p>
                <p class="text-sm text-[#667085] mt-1">Informasi resmi dari sekolah</p>
            </a>
            <a href="{{ route('public.agenda') }}" class="bg-white border border-[#E5E7EB] rounded-xl p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <p class="font-semibold text-navy">Agenda & Kalender Kegiatan</p>
                <p class="text-sm text-[#667085] mt-1">Jadwal kegiatan sekolah</p>
            </a>
            <a href="{{ route('public.ppdb') }}" class="bg-white border border-[#E5E7EB] rounded-xl p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <p class="font-semibold text-navy">PPDB</p>
                <p class="text-sm text-[#667085] mt-1">Informasi penerimaan peserta didik baru</p>
            </a>
            <a href="{{ route('public.download') }}" class="bg-white border border-[#E5E7EB] rounded-xl p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <p class="font-semibold text-navy">Download Dokumen</p>
                <p class="text-sm text-[#667085] mt-1">Unduh formulir dan dokumen sekolah</p>
            </a>
        </div>
    </div>
</x-layouts.public>