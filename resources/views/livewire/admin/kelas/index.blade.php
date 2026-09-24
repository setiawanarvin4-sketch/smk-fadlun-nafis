<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Data Kelas</h1>
        @can('kelola-data')
            <button wire:click="create" class="btn-primary">+ Tambah</button>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kelas..."
        class="border border-[#E5E7EB] rounded px-3 py-2 text-sm mb-4 w-full max-w-xs">

    <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                <tr>
                    <th class="p-3">Nama Kelas</th>
                    <th class="p-3">Kompetensi</th>
                    <th class="p-3">Tingkat</th>
                    <th class="p-3">Wali Kelas</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-t border-[#E5E7EB]">
                        <td class="p-3">{{ $item->nama_kelas }}</td>
                        <td class="p-3">{{ $item->kompetensi->nama ?? '-' }}</td>
                        <td class="p-3">{{ $item->tingkat ?? '-' }}</td>
                        <td class="p-3">
                            @if($item->waliKelas)
                                {{ $item->waliKelas->nama }}
                            @else
                                <span class="text-gray-400 text-xs">Belum ditentukan</span>
                            @endif
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
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="font-semibold text-navy mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Kelas</h2>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="text-sm text-[#667085]">Nama Kelas</label>
                        <input type="text" wire:model="nama_kelas" placeholder="Contoh: X APHP 1" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('nama_kelas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Kompetensi Keahlian</label>
                        <select wire:model="kompetensi_id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="">-- Pilih --</option>
                            @foreach($kompetensiList as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kompetensi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Tingkat</label>
                        <select wire:model="tingkat" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="">-- Pilih --</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Wali Kelas</label>
                        <select wire:model="wali_kelas_id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="">— Belum ditentukan —</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                        @error('wali_kelas_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus kelas ini? Siswa di kelas ini akan ikut terhapus.</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>