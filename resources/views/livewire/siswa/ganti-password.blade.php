<div class="card-premium p-6">
    <h3 class="h-sub mb-4">Ganti Password</h3>

    @if($sukses)
        <div class="bg-green-50 text-green-700 text-sm rounded-xl p-3 mb-4">{{ $sukses }}</div>
    @endif

    <form wire:submit="simpan" class="space-y-4 max-w-sm">
        <div>
            <label class="text-sm font-medium text-navy">Password Lama</label>
            <input type="password" wire:model="password_lama" class="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 mt-1.5 focus:outline-none focus:ring-2 focus:ring-accent-blue/20">
            @error('password_lama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-navy">Password Baru</label>
            <input type="password" wire:model="password_baru" class="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 mt-1.5 focus:outline-none focus:ring-2 focus:ring-accent-blue/20">
            @error('password_baru') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-navy">Ulangi Password Baru</label>
            <input type="password" wire:model="password_baru_konfirmasi" class="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 mt-1.5 focus:outline-none focus:ring-2 focus:ring-accent-blue/20">
            @error('password_baru_konfirmasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <button type="submit" wire:loading.attr="disabled" class="btn-primary">
            <span wire:loading.remove>Simpan Password</span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </form>
</div>