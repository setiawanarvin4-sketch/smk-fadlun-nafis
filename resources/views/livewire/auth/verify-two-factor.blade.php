<div>
    <h1 class="text-2xl font-extrabold text-navy tracking-tight mb-1">Verifikasi Login</h1>
    <p class="text-sm text-[#667085] mb-8">Kode 6 digit sudah dikirim ke email kamu. Masukkan di bawah untuk lanjut masuk.</p>

    @if($error)
        <div class="bg-red-50 text-red-600 text-sm rounded-xl p-3.5 mb-5">{{ $error }}</div>
    @endif
    @if($info)
        <div class="bg-green-50 text-green-700 text-sm rounded-xl p-3.5 mb-5">{{ $info }}</div>
    @endif

    <form wire:submit="verifikasi" class="space-y-4">
        <div>
            <label class="text-sm font-medium text-navy">Kode Verifikasi</label>
            <input type="text" wire:model="kode" maxlength="6" inputmode="numeric" placeholder="123456"
                class="w-full border border-[#E5E7EB] rounded-xl px-4 py-3 mt-1.5 text-center text-2xl tracking-[0.5em] font-bold focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue transition-all">
        </div>
        <button type="submit" class="w-full bg-navy text-white rounded-xl py-3.5 font-bold hover:bg-accent-blue transition-all duration-300 shadow-md hover:shadow-lg">
            Verifikasi & Masuk
        </button>
    </form>

    <button wire:click="kirimUlang" class="w-full text-center text-sm text-accent-blue font-medium mt-5 hover:underline">
        Kirim ulang kode
    </button>
</div>