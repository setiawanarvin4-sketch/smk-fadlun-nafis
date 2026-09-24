<div>
    <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Data Siswa</h1>
        <div class="flex gap-2 flex-wrap">
            <button wire:click="downloadTemplate" class="btn-secondary text-sm">Unduh Template</button>
            <button wire:click="openImportModal" class="btn-secondary text-sm">Import Excel</button>
            <button wire:click="exportExcel" class="btn-secondary text-sm">Export Excel</button>
            <button wire:click="exportRekapKehadiran" class="btn-secondary !px-4 !py-2 text-sm">
                Export Rekap Kehadiran
            </button>
            @can('kelola-data')
                <button wire:click="create" class="btn-primary">+ Tambah</button>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 text-red-600 text-sm rounded p-3 mb-4">{{ session('error') }}</div>
    @endif

    <div class="flex flex-wrap gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama siswa..."
            class="border border-[#E5E7EB] rounded px-3 py-2 text-sm w-full max-w-xs">

        <select wire:model.live="filterKelas" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterKompetensi" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
            <option value="">Semua Kompetensi</option>
            @foreach($kompetensiList as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>

        @can('kelola-data')
            <button wire:click="generateSemuaAkun" wire:confirm="Buatkan akun Portal Siswa untuk semua siswa aktif yang belum punya akun? (siswa tanpa NIS/NISN akan dilewati)" wire:loading.attr="disabled" class="text-sm font-medium bg-navy text-white rounded-lg px-4 py-2 hover:opacity-90 transition-opacity">
                <span wire:loading.remove wire:target="generateSemuaAkun">Buatkan Akun untuk Semua</span>
                <span wire:loading wire:target="generateSemuaAkun">Memproses...</span>
            </button>
        @endcan

        <a href="{{ route('admin.cetak.siswa') }}" target="_blank" class="ml-auto text-sm font-medium border border-[#E5E7EB] rounded-lg px-4 py-2 hover:bg-[#F6F7FA] transition-colors">Cetak Data Siswa</a>
        <a href="{{ route('admin.cetak.kartu-akses') }}" target="_blank" class="text-sm font-medium border border-[#E5E7EB] rounded-lg px-4 py-2 hover:bg-[#F6F7FA] transition-colors">Cetak Kartu Akses</a>
    </div>

    <div class="card-premium overflow-hidden hover:-translate-y-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">NIS/NISN</th>
                        <th class="p-3">Kelas</th>
                        <th class="p-3">Kompetensi</th>
                        <th class="p-3">Akun Portal</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i => $item)
                        <tr class="border-t border-[#E5E7EB]">
                            <td class="p-3">{{ $items->firstItem() + $i }}</td>
                            <td class="p-3">{{ $item->nama }}</td>
                            <td class="p-3 text-[#667085]">{{ $item->nis ?? $item->nisn ?? '-' }}</td>
                            <td class="p-3">{{ $item->kelas->nama_kelas ?? '-' }}</td>
                            <td class="p-3">{{ $item->kompetensi->nama ?? '-' }}</td>
                            <td class="p-3">
                                @if($item->user_id)
                                    <span class="inline-flex items-center gap-1 text-emerald-600 text-xs font-medium">● Aktif</span>
                                    @can('kelola-data')
                                        <button wire:click="resetPasswordAkun({{ $item->id }})" wire:confirm="Reset password akun siswa ini ke default (NISN/NIS)?" class="text-[#667085] hover:text-accent-blue text-xs ml-2 underline">Reset password</button>
                                    @endcan
                                @else
                                    <span class="inline-flex items-center gap-1 text-[#98A2B3] text-xs">● Belum ada</span>
                                    @can('kelola-data')
                                        <button wire:click="generateAkun({{ $item->id }})" class="text-accent-blue text-xs ml-2 underline">Buatkan</button>
                                    @endcan
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
    </div>

    <div class="mt-4">{{ $items->links() }}</div>

    <!-- MODAL TAMBAH/EDIT -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="font-bold text-navy text-lg mb-5">{{ $editId ? 'Edit' : 'Tambah' }} Siswa</h2>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="text-sm text-[#667085]">Nama</label>
                        <input type="text" wire:model="nama" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-[#667085]">NIS</label>
                            <input type="text" wire:model="nis" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            @error('nis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-sm text-[#667085]">NISN</label>
                            <input type="text" wire:model="nisn" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            @error('nisn') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Kelas</label>
                        <select wire:model.live="kelas_id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="">-- Pilih --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Kompetensi Keahlian</label>
                        <input type="text" readonly value="{{ \App\Models\Kompetensi::find($kompetensi_id)?->nama ?? '— pilih kelas dulu —' }}"
                            class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 bg-[#F6F7FA] text-[#667085]">
                        <p class="text-xs text-[#667085] mt-1">Otomatis mengikuti kelas yang dipilih.</p>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">No. WhatsApp Wali (opsional, buat notifikasi otomatis kalau Alpha)</label>
                        <input type="text" wire:model="no_wa_wali" placeholder="08123456789" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                    </div>
                    <div>
                        <label class="text-sm text-[#667085]">Foto (opsional)</label>
                        <input type="file" wire:model="foto" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
                        <div wire:loading wire:target="foto" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
                        @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                                        <div>
                        <label class="text-sm text-[#667085] mb-1 block">Ekstrakurikuler Wajib</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ekstrakurikulerList as $ekstra)
                                <label class="flex items-center gap-1.5 text-xs border border-[#E5E7EB] rounded-lg px-2.5 py-1.5 cursor-pointer">
                                    <input type="checkbox" wire:model="ekstraWajib" value="{{ $ekstra->id }}">
                                    {{ $ekstra->nama }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-[#667085] mb-1 block">Ekstrakurikuler Pilihan</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ekstrakurikulerList as $ekstra)
                                <label class="flex items-center gap-1.5 text-xs border border-[#E5E7EB] rounded-lg px-2.5 py-1.5 cursor-pointer">
                                    <input type="checkbox" wire:model="ekstraPilihan" value="{{ $ekstra->id }}">
                                    {{ $ekstra->nama }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="aktif"> Aktif
                    </label>
                    <div>
                        <label class="text-sm text-[#667085]">Status</label>
                        <select wire:model="status_keluar" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                            <option value="Aktif">Aktif</option>
                            <option value="Lulus">Lulus</option>
                            <option value="Pindah">Pindah Sekolah</option>
                            <option value="Keluar">Keluar</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-sm">Batal</button>
                        <button type="submit" class="btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL IMPORT EXCEL -->
    @if($showImportModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="font-bold text-navy text-lg mb-2">Import Data Siswa</h2>
                <p class="text-sm text-[#667085] mb-5">
                    File harus format <code>.xlsx</code>/<code>.csv</code>, urutan kolom sesuai template.
                    Nama kelas di file harus <strong>persis sama</strong> dengan nama kelas yang sudah ada di sistem.
                </p>

                @if($importBerhasil !== null)
                    <div class="bg-green-50 text-green-700 text-sm rounded-lg p-3 mb-4">
                        {{ $importBerhasil }} data berhasil diimpor.
                    </div>
                @endif

                @if(count($importGagal))
                    <div class="bg-red-50 text-red-600 text-sm rounded-lg p-3 mb-4 max-h-40 overflow-y-auto">
                        <p class="font-semibold mb-1">{{ count($importGagal) }} baris dilewati:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($importGagal as $pesan)
                                <li>{{ $pesan }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form wire:submit="importExcel" class="space-y-4">
                    <input type="file" wire:model="fileImport" accept=".xlsx,.xls,.csv" class="w-full border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                    <div wire:loading wire:target="fileImport" class="text-xs text-[#667085]">Mengunggah file...</div>
                    @error('fileImport') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showImportModal', false)" class="px-4 py-2 text-sm">Tutup</button>
                        <button type="submit" wire:loading.attr="disabled" class="btn-primary">
                            <span wire:loading.remove wire:target="importExcel">Proses Import</span>
                            <span wire:loading wire:target="importExcel">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
        @if($konfirmasiHapusId)
        <div class="fixed inset-0 bg-navy/40 backdrop-blur-sm flex items-center justify-center z-[100] p-4">
            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
                <p class="font-bold text-navy mb-2">Konfirmasi Hapus</p>
                <p class="text-sm text-[#667085] mb-6">Yakin ingin menghapus data ini?</p>
                <div class="flex gap-3">
                    <button wire:click="batalHapus" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="delete({{ $konfirmasiHapusId }})" class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>