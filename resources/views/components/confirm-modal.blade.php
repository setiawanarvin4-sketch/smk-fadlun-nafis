<div x-data="{ open: false, pesan: '', aksi: null }"
     x-on:confirm-hapus.window="open = true; pesan = $event.detail.pesan || 'Yakin ingin menghapus?'; aksi = $event.detail.aksi"
     x-show="open" x-cloak
     class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-navy/40 backdrop-blur-sm">
    <div @click.outside="open = false" class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
        <p class="font-bold text-navy mb-2">Konfirmasi</p>
        <p class="text-sm text-[#667085] mb-6" x-text="pesan"></p>
        <div class="flex gap-3">
            <button @click="open = false" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
            <button @click="$wire.call(aksi); open = false" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
        </div>
    </div>
</div>