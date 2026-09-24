<x-layouts.public :title="'PPDB' . ($ppdb->tahun_ajaran ? ' Tahun Ajaran '.$ppdb->tahun_ajaran : '')" description="Informasi penerimaan peserta didik baru SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Penerimaan Peserta Didik Baru" title="{{ 'PPDB' . ($ppdb->tahun_ajaran ? ' Tahun Ajaran '.$ppdb->tahun_ajaran : '') }}" />
    <div class="max-w-[800px] mx-auto px-4 py-14">

        @if($ppdb->status === 'Dibuka')
            <span class="inline-block bg-light-blue text-accent-blue text-xs font-semibold px-3 py-1 rounded-full mt-2">Pendaftaran Dibuka</span>
        @else
            <span class="inline-block bg-gray-100 text-gray-500 text-xs font-semibold px-3 py-1 rounded-full mt-2">Pendaftaran Ditutup</span>
        @endif

        <div class="bg-white border border-[#E5E7EB] rounded-xl p-6 mt-6 space-y-6">
            @if($ppdb->jadwal)
                <div>
                    <h2 class="font-semibold text-navy mb-2">Jadwal Pendaftaran</h2>
                    <div class="prose prose-sm max-w-none">{!! $ppdb->jadwal !!}</div>
                </div>
            @endif
            @if($ppdb->persyaratan)
                <div>
                    <h2 class="font-semibold text-navy mb-2">Persyaratan</h2>
                    <div class="prose prose-sm max-w-none">{!! $ppdb->persyaratan !!}</div>
                </div>
            @endif
            @if($ppdb->alur_pendaftaran)
                <div>
                    <h2 class="font-semibold text-navy mb-2">Alur Pendaftaran</h2>
                    <div class="prose prose-sm max-w-none">{!! $ppdb->alur_pendaftaran !!}</div>
                </div>
            @endif
            @if($ppdb->faq)
                <div>
                    <h2 class="font-semibold text-navy mb-2">FAQ</h2>
                    <div class="prose prose-sm max-w-none">{!! $ppdb->faq !!}</div>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center">
            @if($ppdb->status === 'Dibuka')
                <a href="{{ $ppdb->url_ppdb_resmi }}" target="_blank" class="inline-block bg-navy text-white px-6 py-3 rounded-lg font-semibold hover:bg-navy/90 transition-colors">DAFTAR PPDB ONLINE</a>
            @else
                <span class="inline-block bg-gray-200 text-gray-500 px-6 py-3 rounded-lg font-semibold">Pendaftaran Telah Ditutup</span>
            @endif
        </div>
    </div>
</x-layouts.public>