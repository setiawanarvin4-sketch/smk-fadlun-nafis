<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Berita</h1>
        @can('kelola-data')
            <button wire:click="create" class="btn-primary">+ Tambah</button>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="flex flex-wrap gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul..."
            class="border border-[#E5E7EB] rounded px-3 py-2 text-sm w-full max-w-xs">
        <select wire:model.live="filterStatus" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
            <option value="">Semua Status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>
    </div>

    <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                <tr>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-t border-[#E5E7EB]">
                        <td class="p-3">{{ $item->judul }}</td>
                        <td class="p-3">{{ $item->kategori }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs
                                @class([
                                    'bg-green-50 text-green-700' => $item->status === 'published',
                                    'bg-gray-100 text-gray-500' => $item->status === 'draft',
                                    'bg-yellow-50 text-yellow-700' => $item->status === 'archived',
                                ])">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-[#667085]">{{ $item->tanggal_publikasi?->format('d/m/Y') ?? '-' }}</td>
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
                <h2 class="font-semibold text-navy mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Berita</h2>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="text-sm text-[#667085]">Judul</label>
                        <input type="text" wire:model="judul" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('judul') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Ringkasan</label>
                        <textarea wire:model="ringkasan" rows="2" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Isi Berita</label>
                        <textarea wire:model="isi" rows="6" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                        @error('isi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Kategori</label>
                        <select wire:model="kategori" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="Umum">Umum</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Prestasi">Prestasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Thumbnail</label>
                        <input type="file" wire:model="thumbnail" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
                        <div wire:loading wire:target="thumbnail" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Status</label>
                        <select wire:model="status" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
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
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus berita ini?</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>