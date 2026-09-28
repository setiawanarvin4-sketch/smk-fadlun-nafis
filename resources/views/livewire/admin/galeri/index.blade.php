<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Galeri</h1>
        @can('kelola-konten')
            <button wire:click="create" class="btn-primary">+ Tambah</button>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul..."
        class="border border-[#E5E7EB] rounded px-3 py-2 text-sm mb-4 w-full max-w-xs">

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($items as $item)
            <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-hidden">
                <img src="{{ asset('storage/'.$item->file) }}" class="w-full h-32 object-cover">                <div class="p-3">
                    <p class="text-sm font-medium truncate">{{ $item->judul }}</p>
                    <p class="text-xs text-[#667085]">{{ $item->kategori }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="px-2 py-0.5 rounded text-xs {{ $item->aktif ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        @can('kelola-konten')
                            <div class="space-x-2 text-xs">
                                <button wire:click="edit({{ $item->id }})" class="text-accent-blue px-1.5 py-1 inline-block">Edit</button>
                                <button wire:click="konfirmasiHapus({{ $item->id }})" class="text-red-500 px-1.5 py-1 inline-block">Hapus</button>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $items->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2l p-6 w-full max-w-md shadow-2xl">
                <h2 class="font-semibold text-navy mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Galeri</h2>
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
                        <label class="text-sm text-[#667085]">Kategori</label>
                        <select wire:model="kategori" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option>Kegiatan Sekolah</option>
                            <option>Pembelajaran</option>
                            <option>APHP</option>
                            <option>Farmasi</option>
                            <option>Prestasi</option>
                            <option>Event</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Foto</label>
                        <input type="file" wire:model="file" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
                        <div wire:loading wire:target="file" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus foto galeri ini?</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>