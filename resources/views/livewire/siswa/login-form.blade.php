<div>
    <h1 class="text-2xl font-semibold text-navy tracking-tight mb-1">Portal Siswa</h1>
    <p class="text-sm text-[#667085] mb-8">Masuk pakai NIS & password. Untuk orang tua/wali, silakan gunakan akun anak.</p>

    @if($error)
        <div class="bg-red-50 text-red-600 text-sm rounded-xl p-3.5 mb-5">{{ $error }}</div>
    @endif

    <form wire:submit="login" class="space-y-4">
        <div>
            <label class="text-sm font-medium text-navy">NIS</label>
            <div class="relative mt-1.5">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#98A2B3]" style="width:1.1rem;height:1.1rem" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2-8 4.5V21h16v-2.5c0-2.5-3.6-4.5-8-4.5z"/></svg>
                <input type="text" wire:model="nis" class="w-full border border-[#E5E7EB] rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue transition-all">
            </div>
            @error('nis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-navy">Password</label>
            <div class="relative mt-1.5">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#98A2B3]" style="width:1.1rem;height:1.1rem" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <input type="password" wire:model="password" class="w-full border border-[#E5E7EB] rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue transition-all">
            </div>
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <p class="text-xs text-[#98A2B3] mt-1.5">Password awal = NISN (atau NIS kalau NISN belum diisi).</p>
        </div>
        <button type="submit" wire:loading.attr="disabled" class="group w-full bg-gradient-to-r from-navy to-accent-blue text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-accent-blue/25 transition-all duration-300 mt-2 flex items-center justify-center gap-2">
            <span wire:loading.remove class="flex items-center gap-2">
                Masuk
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
            </span>
            <span wire:loading>Memproses...</span>
        </button>
    </form>

    <a href="{{ route('home') }}" class="flex items-center justify-center gap-1.5 text-sm text-[#667085] hover:text-accent-blue mt-6 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Beranda
    </a>

    <p class="text-center text-xs text-[#98A2B3] mt-4">
        Lupa password? Hubungi wali kelas atau Admin sekolah untuk di-reset.
    </p>
</div>