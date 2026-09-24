<x-layouts.public title="SiAdik" description="Informasi dan akses SiAdik — sistem akademik resmi SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Sistem Akademik Sekolah" title="SiAdik" subtitle="Akses sistem informasi akademik resmi SMK Fadlun Nafis Bangsri." />

    <div class="max-w-[800px] mx-auto px-4 py-14">
        @if($siadik->deskripsi)
            <div class="prose prose-sm max-w-none mb-8">{!! $siadik->deskripsi !!}</div>
        @endif

        @if(!empty($siadik->galeri))
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-8">
                @foreach($siadik->galeri as $path)
                    <img src="{{ asset('storage/'.$path) }}" class="w-full h-32 sm:h-40 object-cover rounded-xl border border-[#E5E7EB]">
                @endforeach
            </div>
        @endif

        <a href="{{ $siadik->url_siadik }}" target="_blank" rel="noopener"
           class="flex items-center justify-center gap-2 bg-gradient-to-r from-navy to-accent-blue text-white text-sm font-bold px-6 py-4 rounded-xl shadow-lg shadow-accent-blue/20 w-full sm:w-auto sm:inline-flex">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
            Buka SiAdik
        </a>

        <p class="text-xs text-[#667085] mt-4">
            SiAdik dikelola dan diakses secara terpisah dari website ini — halaman ini hanya menampilkan
            informasi dan tautan aksesnya.
        </p>
    </div>
</x-layouts.public>