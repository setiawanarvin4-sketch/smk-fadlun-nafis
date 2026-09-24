<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Hero Slider</h1>
        @can('kelola-data')
            <button wire:click="create" class="btn-primary">+ Tambah</button>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                <tr>
                    <th class="p-3">Urutan</th>
                    <th class="p-3">Foto</th>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-t border-[#E5E7EB]">
                        <td class="p-3">{{ $item->urutan }}</td>
                        <td class="p-3">
                            <img src="{{ asset('storage/'.$item->foto) }}" class="w-16 h-10 object-cover rounded">
                        </td>
                        <td class="p-3">{{ $item->judul }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs {{ $item->aktif ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-2">
                            @can('kelola-data')
                                <button wire:click="edit({{ $item->id }})" class="text-accent-blue px-1.5 py-1 inline-block">Edit</button>
                                <button wire:click="konfirmasiHapus({{ $item->id }})" class="text-red-500 px-1.5 py-1 inline-block">Hapus</button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <h2 class="font-semibold text-navy mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Hero Slider</h2>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="text-sm text-[#667085]">Judul</label>
                        <input type="text" wire:model="judul" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('judul') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Deskripsi</label>
                        <textarea wire:model="deskripsi" rows="2" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Badge (opsional, misal "SMK FADLUN NAFIS")</label>
                        <input type="text" wire:model="badge" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-[#667085]">Tombol 1 Teks</label>
                            <input type="text" wire:model="button1_text" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Tombol 1 URL</label>
                            <input type="text" wire:model="button1_url" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-[#667085]">Tombol 2 Teks</label>
                            <input type="text" wire:model="button2_text" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Tombol 2 URL</label>
                            <input type="text" wire:model="button2_url" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-[#667085]">Urutan</label>
                            <input type="number" wire:model="urutan" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Foto Background</label>
                        <input type="file" wire:model="foto" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
                        <div wire:loading wire:target="foto" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
                        @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="aktif"> Aktif
                    </label>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-sm">Batal</button>
                        <button type="submit" class="bg-navy text-white px-4 py-2 rounded text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($konfirmasiHapusId)
        <div class="fixed inset-0 bg-navy/40 backdrop-blur-sm flex items-center justify-center z-[100] p-4">
            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
                <p class="font-bold text-navy mb-2">Konfirmasi Hapus</p>
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus slide ini?</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>