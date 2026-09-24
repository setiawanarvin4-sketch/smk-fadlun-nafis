<x-layouts.public title="Hubungi Kami" description="Kontak dan lokasi SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Kami Siap Membantu" title="Hubungi Kami" subtitle="Ada pertanyaan seputar sekolah, PPDB, atau kerja sama? Kontak kami lewat cara di bawah." />

    <div class="max-w-[1100px] mx-auto px-4 py-14">
        <div class="grid md:grid-cols-3 gap-5 mb-10">
            @if($pengaturan->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_starts_with($pengaturan->whatsapp, '0') ? '62'.substr($pengaturan->whatsapp, 1) : $pengaturan->whatsapp) }}" target="_blank" rel="noopener"
                   class="card-premium p-6 flex items-center gap-4 hover:border-emerald-500/40">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500 flex items-center justify-center text-white flex-shrink-0 shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.79 14.08c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.98 0-1.42.74-2.11 1-2.4.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.58.81 2 .88 2.14.07.15.11.32.02.51-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.27.37-.22.62-.13.25.09 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-navy">WhatsApp</p>
                        <p class="text-xs text-[#667085] mt-0.5">Chat langsung</p>
                    </div>
                </a>
            @endif
            @if($pengaturan->telepon)
                <a href="tel:{{ $pengaturan->telepon }}" class="card-premium p-6 flex items-center gap-4 hover:border-accent-blue/40">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-navy">Telepon</p>
                        <p class="text-xs text-[#667085] mt-0.5">{{ $pengaturan->telepon }}</p>
                    </div>
                </a>
            @endif
            @if($pengaturan->email)
                <a href="mailto:{{ $pengaturan->email }}" class="card-premium p-6 flex items-center gap-4 hover:border-accent-blue/40">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0 shadow-md">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-navy">Email</p>
                        <p class="text-xs text-[#667085] mt-0.5 break-all">{{ $pengaturan->email }}</p>
                    </div>
                </a>
            @endif
        </div>

        <div class="grid md:grid-cols-[1fr_1.3fr] gap-6">
            <div class="card-premium hover:-translate-y-0 p-7">
                <p class="h-eyebrow">Alamat</p>
                <h2 class="h-sub mb-3">{{ $pengaturan->nama_sekolah }}</h2>
                <p class="h-body mb-6">{{ $pengaturan->alamat ?? 'Bangsri, Jepara, Jawa Tengah' }}</p>

                @if($pengaturan->instagram || $pengaturan->facebook || $pengaturan->youtube || $pengaturan->tiktok)
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#667085] mb-3">Ikuti Kami</p>
                    <div class="flex items-center gap-2.5">
                        @if($pengaturan->instagram)
                            <a href="{{ $pengaturan->instagram }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-[#F6F7FA] hover:bg-light-blue flex items-center justify-center text-navy hover:text-accent-blue transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c2.7 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.22.6 1.77 1.15.55.55.9 1.11 1.15 1.77.25.64.42 1.37.47 2.43.05 1.06.06 1.42.06 4.12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 01-1.15 1.77 4.9 4.9 0 01-1.77 1.15c-.64.25-1.37.42-2.43.47-1.06.05-1.42.06-4.12.06s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 01-1.77-1.15 4.9 4.9 0 01-1.15-1.77c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.7 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.22 1.15-1.77A4.9 4.9 0 015.45 2.53c.64-.25 1.37-.42 2.43-.47C8.94 2.01 9.3 2 12 2zm0 5a5 5 0 100 10 5 5 0 000-10zm0 8.2a3.2 3.2 0 110-6.4 3.2 3.2 0 010 6.4zm5.2-8.4a1.17 1.17 0 100-2.34 1.17 1.17 0 000 2.34z"/></svg>
                            </a>
                        @endif
                        @if($pengaturan->facebook)
                            <a href="{{ $pengaturan->facebook }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-[#F6F7FA] hover:bg-light-blue flex items-center justify-center text-navy hover:text-accent-blue transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z"/></svg>
                            </a>
                        @endif
                        @if($pengaturan->youtube)
                            <a href="{{ $pengaturan->youtube }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-[#F6F7FA] hover:bg-light-blue flex items-center justify-center text-navy hover:text-accent-blue transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.6 3.5 12 3.5 12 3.5s-7.6 0-9.4.6A3 3 0 00.5 6.2 31 31 0 000 12a31 31 0 00.5 5.8 3 3 0 002.1 2.1c1.8.6 9.4.6 9.4.6s7.6 0 9.4-.6a3 3 0 002.1-2.1A31 31 0 0024 12a31 31 0 00-.5-5.8zM9.6 15.6V8.4l6.3 3.6-6.3 3.6z"/></svg>
                            </a>
                        @endif
                        @if($pengaturan->tiktok)
                            <a href="{{ $pengaturan->tiktok }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-[#F6F7FA] hover:bg-light-blue flex items-center justify-center text-navy hover:text-accent-blue transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16.6 5.82a4.28 4.28 0 01-.6-3.55h-3.28v13.4a2.6 2.6 0 11-2.6-2.6c.24 0 .47.03.68.09V9.8a5.9 5.9 0 00-.68-.04A5.9 5.9 0 108.7 21.6a5.9 5.9 0 005.9-5.9V9.1a7.6 7.6 0 004.4 1.4V7.2a4.28 4.28 0 01-2.4-1.38z"/></svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="relative rounded-2xl overflow-hidden shadow-sm border border-[#EDEEF0]">
                @if($pengaturan->latitude && $pengaturan->longitude)
                    <iframe
                        class="w-full h-full min-h-[280px]"
                        src="https://maps.google.com/maps?q={{ $pengaturan->latitude }},{{ $pengaturan->longitude }}&z=15&output=embed"
                        loading="lazy"></iframe>
                @else
                    <div class="w-full h-full min-h-[280px] bg-[#F6F7FA] flex items-center justify-center text-[#667085] text-sm">
                        Koordinat lokasi belum diatur Admin.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.public>