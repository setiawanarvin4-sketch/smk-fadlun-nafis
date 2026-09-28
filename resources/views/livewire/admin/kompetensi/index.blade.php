<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Kompetensi Keahlian</h1>
        @can('kelola-data')
            <button wire:click="create" class="btn-primary">+ Tambah</button>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kompetensi..."
        class="border border-[#E5E7EB] rounded px-3 py-2 text-sm mb-4 w-full max-w-xs">

    <div class="card-premium overflow-hidden hover:-translate-y-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                    <tr>
                        <th class="p-3">Logo</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Kepala Jurusan</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr class="border-t border-[#E5E7EB]">
                            <td class="p-3">
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 rounded bg-light-blue"></div>
                                @endif
                            </td>
                            <td class="p-3">{{ $item->nama }}</td>
                            <td class="p-3 text-[#667085]">{{ $item->kepala_jurusan_nama ?: '-' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs {{ $item->aktif ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-3 text-right space-x-2">
                                @can('kelola-data')
                                    <button wire:click="edit({{ $item->id }})" class="text-accent-blue font-medium">Edit</button>
                                    <button wire:click="konfirmasiHapus({{ $item->id }})" class="text-red-500">Hapus</button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <h2 class="font-bold text-navy text-lg mb-5">{{ $editId ? 'Edit' : 'Tambah' }} Kompetensi</h2>
                <form wire:submit="save" class="space-y-5">

                    <div class="border border-[#E5E7EB] rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-accent-blue mb-3">1. Logo / Foto Jurusan</p>
                        @if($foto)
                            <img src="{{ $foto->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-xl mb-2">
                        @elseif($editId && $existingFoto)
                            <img src="{{ asset('storage/'.$existingFoto) }}" class="w-24 h-24 object-cover rounded-xl mb-2">
                        @endif
                        <input type="file" wire:model="foto" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                        <div wire:loading wire:target="foto" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
                        @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="border border-[#E5E7EB] rounded-xl p-4 space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-accent-blue mb-1">2. Identitas</p>
                        <div>
                            <label class="text-sm text-[#667085]">Nama Kompetensi</label>
                            <input type="text" wire:model="nama" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Deskripsi Singkat (tampil di kartu homepage)</label>
                            <textarea wire:model="deskripsi" rows="2" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Profil Singkat (tampil di halaman detail)</label>
                            <textarea wire:model="profil_singkat" rows="3" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Prospek Karir Lulusan (opsional)</label>
                            <textarea wire:model="prospek_karir" rows="3" placeholder="Contoh: Analis laboratorium, wirausaha agribisnis, staf farmasi apotek, dst." class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                        </div>
                    </div>

                    <div class="border border-[#E5E7EB] rounded-xl p-4 space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-accent-blue mb-1">3. Visi & Misi Jurusan</p>
                        <div>
                            <label class="text-sm text-[#667085]">Visi</label>
                            <textarea wire:model="visi" rows="2" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Misi (boleh per-baris pakai enter)</label>
                            <textarea wire:model="misi" rows="4" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
                        </div>
                    </div>

                    <div class="border border-[#E5E7EB] rounded-xl p-4 space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-accent-blue mb-1">4. Kepala Jurusan</p>
                        @if($kepala_jurusan_foto)
                            <img src="{{ $kepala_jurusan_foto->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover mb-2">
                        @elseif($editId && $existingKepalaFoto)
                            <img src="{{ asset('storage/'.$existingKepalaFoto) }}" class="w-20 h-20 rounded-full object-cover mb-2">
                        @endif
                        <input type="file" wire:model="kepala_jurusan_foto" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                        <div wire:loading wire:target="kepala_jurusan_foto" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
                        <div class="grid grid-cols-2 gap-3 mt-2">
                            <div>
                                <label class="text-sm text-[#667085]">Nama</label>
                                <input type="text" wire:model="kepala_jurusan_nama" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            </div>
                            <div>
                                <label class="text-sm text-[#667085]">Jabatan</label>
                                <input type="text" wire:model="kepala_jurusan_jabatan" placeholder="Kepala Kompetensi Keahlian" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            </div>
                        </div>
                    </div>

                    <div class="border border-[#E5E7EB] rounded-xl p-4 space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-accent-blue mb-1">5. Foto Kegiatan/Praktik (opsional, sampai 3 foto)</p>
                        <div>
                            <input type="file" wire:model="foto_kegiatan_1" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                            @if($existingFotoKegiatan1 && !$foto_kegiatan_1)
                                <img src="{{ asset('storage/'.$existingFotoKegiatan1) }}" class="w-20 h-14 object-cover rounded mt-1">
                            @endif
                        </div>
                        <div>
                            <input type="file" wire:model="foto_kegiatan_2" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                            @if($existingFotoKegiatan2 && !$foto_kegiatan_2)
                                <img src="{{ asset('storage/'.$existingFotoKegiatan2) }}" class="w-20 h-14 object-cover rounded mt-1">
                            @endif
                        </div>
                        <div>
                            <input type="file" wire:model="foto_kegiatan_3" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                            @if($existingFotoKegiatan3 && !$foto_kegiatan_3)
                                <img src="{{ asset('storage/'.$existingFotoKegiatan3) }}" class="w-20 h-14 object-cover rounded mt-1">
                            @endif
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="aktif"> Aktif (tampil di website)
                    </label>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-sm">Batal</button>
                        <button type="submit" class="btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($konfirmasiHapusId)
        <div class="fixed inset-0 bg-navy/40 backdrop-blur-sm flex items-center justify-center z-[100] p-4">
            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
                <p class="font-bold text-navy mb-2">Konfirmasi Hapus</p>
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus kompetensi ini? Foto jurusan dan kegiatan akan ikut terhapus.</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>