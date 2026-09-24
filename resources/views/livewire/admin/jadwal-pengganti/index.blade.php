<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Jadwal Pengganti</h1>
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
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Jam</th>
                    <th class="p-3">Guru Pengganti</th>
                    <th class="p-3">Kelas</th>
                    <th class="p-3">Mapel</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-t border-[#E5E7EB]">
                        <td class="p-3">{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td class="p-3">{{ substr($item->jam_mulai,0,5) }} - {{ substr($item->jam_selesai,0,5) }}</td>
                        <td class="p-3">{{ $item->guru->nama ?? '-' }}</td>
                        <td class="p-3">{{ $item->kelas->nama_kelas ?? '-' }}</td>
                        <td class="p-3">{{ $item->mataPelajaran->nama ?? '-' }}</td>
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
                <h2 class="font-semibold text-navy mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Jadwal Pengganti</h2>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="text-sm text-[#667085]">Guru Pengganti</label>
                        <select wire:model.live="guru_id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="">-- Pilih --</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                        @error('guru_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Kelas</label>
                        <select wire:model="kelas_id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="">-- Pilih --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Mata Pelajaran</label>
                        <select wire:model="mata_pelajaran_id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1" @if(!$guru_id) disabled @endif>
                            <option value="">-- Pilih --</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                            @endforeach
                        </select>
                        @if($guru_id && $mapelList->isEmpty())
                            <p class="text-xs text-red-500 mt-1">Guru ini belum diatur mata pelajarannya. Atur dulu di menu Guru.</p>
                        @endif
                        @error('mata_pelajaran_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Tanggal</label>
                        <input type="date" wire:model="tanggal" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-[#667085]">Jam Mulai</label>
                            <input type="time" wire:model="jam_mulai" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">Jam Selesai</label>
                            <input type="time" wire:model="jam_selesai" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        </div>
                    </div>
                    @error('jam_selesai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <div>
                        <label class="text-sm text-[#667085]">Keterangan</label>
                        <textarea wire:model="keterangan" rows="2" placeholder="Contoh: menggantikan Bu Sari yang sakit" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
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
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus jadwal pengganti ini?</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>