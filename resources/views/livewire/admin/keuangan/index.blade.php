<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Laporan Keuangan</h1>
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
                    <th class="p-3">Judul</th>
                    <th class="p-3">Visibilitas</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-t border-[#E5E7EB]">
                        <td class="p-3">{{ $item->judul }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs {{ $item->visibilitas === 'publik' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ ucfirst($item->visibilitas) }}
                            </span>
                        </td>
                        <td class="p-3">{{ ucfirst($item->status) }}</td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ asset('storage/'.$item->file) }}" target="_blank" class="text-accent-blue">Lihat</a>
                            @can('kelola-data')
                                <button wire:click="edit({{ $item->id }})" </button>
                                <button wire:click="konfirmasiHapus({{ $item->id }})" class="text-red-500">Hapus</button>
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
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="font-semibold text-navy mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Laporan Keuangan</h2>
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
                        <label class="text-sm text-[#667085]">File (PDF/Excel, maks 5MB)</label>
                        <input type="file" wire:model="file" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-[#667085]">Visibilitas</label>
                            <select wire:model="visibilitas" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                                <option value="internal">Internal</option>
                                <option value="publik">Publik</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Status</label>
                            <select wire:model="status" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
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
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus laporan keuangan ini?</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>