<div>
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-extrabold text-navy tracking-tight">Kelola Akun</h1>
            <p class="text-sm text-[#667085] mt-1">Akun Admin (akses penuh) dan Kepala Sekolah (hanya lihat laporan, tidak bisa edit/hapus data).</p>
        </div>
        <button wire:click="create" class="btn-primary whitespace-nowrap">+ Tambah Akun</button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Peran</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t border-[#E5E7EB]">
                        <td class="p-3">{{ $item->name }} @if($item->id === auth()->id()) <span class="text-xs text-[#667085]">(kamu)</span> @endif</td>
                        <td class="p-3">{{ $item->email }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs {{ $item->role === 'admin' ? 'bg-navy text-white' : 'bg-light-blue text-accent-blue' }}">
                                {{ $item->role === 'admin' ? 'Admin' : 'Kepala Sekolah' }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-2">
                            <button wire:click="edit({{ $item->id }})" class="text-accent-blue px-1.5 py-1 inline-block">Edit</button>
                            @if($item->id !== auth()->id())
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus akun ini?" class="text-red-500 px-1.5 py-1 inline-block">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-6 text-center text-sm text-[#667085]">Belum ada akun lain.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <h2 class="font-semibold text-navy mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Akun</h2>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="text-sm text-[#667085]">Nama</label>
                        <input type="text" wire:model="name" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Email</label>
                        <input type="email" wire:model="email" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div x-show="$wire.role === 'jurnalistik'" class="mt-3">
                        <label class="text-sm font-medium text-navy">Nama Pena (tampil di publik, boleh dikosongkan)</label>
                        <input type="text" wire:model="nama_pena" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1" placeholder="Misal: Tim Jurnalistik SMK">
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Peran</label>
                        <select wire:model="role" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="kepala_sekolah">Kepala Sekolah (hanya lihat laporan)</option>
                            <option value="admin">Admin (akses penuh)</option>
                            <option value="jurnalistik">Jurnalistik</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Password {{ $editId ? '(kosongkan kalau tidak diganti)' : '' }}</label>
                        <input type="password" wire:model="password" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-sm">Batal</button>
                        <button type="submit" class="bg-navy text-white px-4 py-2 rounded text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>