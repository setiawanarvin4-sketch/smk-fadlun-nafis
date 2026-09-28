<div>
    <h1 class="text-xl font-semibold text-navy mb-4">Rekap Absensi</h1>

    <div class="flex flex-wrap gap-3 mb-4">
        <select wire:model.live="filterKelas" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterGuru" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
            <option value="">Semua Guru</option>
            @foreach($guruList as $g)
                <option value="{{ $g->id }}">{{ $g->nama }}</option>
            @endforeach
        </select>
        <input type="date" wire:model.live="filterTanggal" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
        <input type="month" wire:model="exportBulan" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
        <button wire:click="exportExcel" class="btn-secondary text-sm">
            Export Excel {{ $exportBulan ? '('.\Carbon\Carbon::parse($exportBulan.'-01')->translatedFormat('F Y').')' : '(Semua Data)' }}
        </button>
    </div>

    <div class="flex justify-end mb-4">
        <button wire:click="exportRekapGuruBulanan" class="btn-secondary text-sm">
            Export Rekap Guru
        </button>
    </div>


    @if($tidakHadirList->count())
        <div class="mb-6">
            <p class="text-sm font-semibold text-navy mb-2">Guru Tidak Hadir Mengajar</p>
            <div class="bg-red-50 border border-red-200 rounded-lg divide-y divide-red-200">
                @foreach($tidakHadirList as $t)
                    <div wire:click="openTidakHadirDetail({{ $t->id }})"
                        class="p-3 text-sm flex flex-wrap items-center justify-between gap-2 cursor-pointer hover:bg-red-100/60 transition-colors">
                        <div class="min-w-0">
                            <span class="font-medium">{{ $t->guru->nama ?? '-' }}</span>
                            <span class="text-[#667085]"> — {{ $t->kelas->nama_kelas ?? '-' }} — {{ $t->mataPelajaran->nama ?? '-' }} — {{ $t->tanggal->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="px-2.5 py-1 rounded text-xs bg-red-100 text-red-700 font-medium">{{ $t->alasan }}</span>
                            <span class="px-2.5 py-1 rounded text-xs font-medium
                                @class([
                                    'bg-green-100 text-green-700' => $t->status === 'Disetujui',
                                    'bg-gray-200 text-gray-600' => $t->status === 'Ditolak',
                                    'bg-yellow-100 text-yellow-700' => $t->status === 'Menunggu',
                                ])">{{ $t->status }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <p class="text-sm font-semibold text-navy mb-2">Sesi Mengajar</p>
    <p class="text-xs text-[#667085] mb-3">Klik baris untuk lihat detail kehadiran per siswa.</p>

    <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                <tr>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Kelas</th>
                    <th class="p-3">Mapel</th>
                    <th class="p-3">Guru</th>
                    <th class="p-3">Kehadiran</th>
                    <th class="p-3">Jurnal</th>
                    <th class="p-3">Jam</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $sesi)
                    @php
                        $hadir = $sesi->absensi->where('status', 'Hadir')->count();
                        $izin = $sesi->absensi->where('status', 'Izin')->count();
                        $sakit = $sesi->absensi->where('status', 'Sakit')->count();
                        $alpha = $sesi->absensi->where('status', 'Alpha')->count();
                    @endphp
                    <tr wire:click="openDetail({{ $sesi->id }})" class="border-t border-[#E5E7EB] cursor-pointer hover:bg-[#F6F7FA] transition-colors">
                        <td class="p-3">{{ $sesi->tanggal->format('d/m/Y') }}</td>
                        <td class="p-3 font-medium">{{ $sesi->kelas->nama_kelas ?? '-' }}</td>
                        <td class="p-3">{{ $sesi->mataPelajaran->nama ?? '-' }}</td>
                        <td class="p-3">{{ $sesi->guru->nama ?? '-' }}</td>
                        <td class="p-3">
                            <div class="flex gap-1.5 flex-wrap">
                                <span class="px-2 py-0.5 rounded-full text-xs bg-green-50 text-green-700">{{ $hadir }} Hadir</span>
                                @if($izin) <span class="px-2 py-0.5 rounded-full text-xs bg-yellow-50 text-yellow-700">{{ $izin }} Izin</span> @endif
                                @if($sakit) <span class="px-2 py-0.5 rounded-full text-xs bg-orange-50 text-orange-700">{{ $sakit }} Sakit</span> @endif
                                @if($alpha) <span class="px-2 py-0.5 rounded-full text-xs bg-red-50 text-red-600">{{ $alpha }} Alpha</span> @endif
                            </div>
                        </td>
                        <td class="p-3 text-[#667085] max-w-[160px] truncate" title="{{ $sesi->materi }}">
                            {{ $sesi->materi ?: '-' }}
                        </td>
                        <td class="p-3 text-[#667085]">
                            {{ $sesi->waktu_mulai ? \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') : '-' }}
                            @if($sesi->status_kedatangan === 'Terlambat')
                                <span class="ml-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 align-middle">Terlambat</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-6 text-center text-[#667085]">Belum ada data absensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>

    @if($showDetail && $detailSesi)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="font-semibold text-navy">{{ $detailSesi->kelas->nama_kelas }} — {{ $detailSesi->mataPelajaran->nama }}</h2>
                        <p class="text-sm text-[#667085]">
                            {{ $detailSesi->guru->nama }} — {{ $detailSesi->tanggal->translatedFormat('d F Y') }}
                            @if($detailSesi->status_kedatangan === 'Terlambat')
                                <span class="ml-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 align-middle">Terlambat</span>
                            @endif
                        </p>
                    </div>
                    <button wire:click="$set('showDetail', false)" class="text-[#667085] hover:text-navy">✕</button>

                @can('kelola-data')
                    <button wire:click="batalkanSesi({{ $detailSesi->id }})"
                        wire:confirm="Yakin batalkan sesi ini? Semua data absensi di sesi ini akan terhapus, dan guru harus mengisi ulang dari jadwal yang benar."
                        class="text-red-600 text-xs font-semibold hover:underline">
                        Batalkan Sesi (Salah Pilih Kelas)
                    </button>
                @endcan
                </div>

                @if($detailSesi->kegiatan || $detailSesi->kendala)
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        @if($detailSesi->kegiatan)
                            <div class="bg-[#F6F7FA] rounded-lg p-3">
                                <p class="text-xs text-[#667085] font-medium mb-1">Kegiatan</p>
                                <p class="text-sm text-navy">{{ $detailSesi->kegiatan }}</p>
                            </div>
                        @endif
                        @if($detailSesi->kendala)
                            <div class="bg-red-50 rounded-lg p-3">
                                <p class="text-xs text-red-500 font-medium mb-1">Kendala</p>
                                <p class="text-sm text-red-700">{{ $detailSesi->kendala }}</p>
                            </div>
                        @endif
                    </div>
                @endif
        
                @if($detailSesi->materi)
                    <div class="bg-[#F6F7FA] rounded-lg p-3 mb-4">
                        <p class="text-xs text-[#667085] font-medium mb-1">Materi yang Diajarkan</p>
                        <p class="text-sm text-navy">{{ $detailSesi->materi }}</p>
                    </div>
                @endif

                <p class="text-sm font-medium text-navy mb-2">Daftar Kehadiran ({{ $detailSesi->absensi->count() }} siswa)</p>
                <div class="max-h-64 overflow-y-auto space-y-1">
                    @foreach($detailSesi->absensi as $row)
                        <div class="flex justify-between items-center text-sm border-b border-[#E5E7EB] py-2">
                            <span>{{ $row->siswa->nama ?? '-' }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs
                                @class([
                                    'bg-green-50 text-green-700' => $row->status === 'Hadir',
                                    'bg-yellow-50 text-yellow-700' => in_array($row->status, ['Izin', 'Sakit']),
                                    'bg-red-50 text-red-600' => $row->status === 'Alpha',
                                ])">
                                {{ $row->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($showTidakHadirDetail && $detailTidakHadir)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-start justify-center z-50 overflow-y-auto py-12">
            <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="font-semibold text-navy">Detail Ketidakhadiran</h2>
                    <button wire:click="$set('showTidakHadirDetail', false)" class="text-[#667085] hover:text-navy">✕</button>
                </div>
                <div class="space-y-2 text-sm">
                    <p><span class="text-[#667085]">Guru:</span> <span class="font-medium">{{ $detailTidakHadir->guru->nama ?? '-' }}</span></p>
                    <p><span class="text-[#667085]">Kelas:</span> {{ $detailTidakHadir->kelas->nama_kelas ?? '-' }}</p>
                    <p><span class="text-[#667085]">Mapel:</span> {{ $detailTidakHadir->mataPelajaran->nama ?? '-' }}</p>
                    <p><span class="text-[#667085]">Tanggal:</span> {{ $detailTidakHadir->tanggal->format('d/m/Y') }}</p>
                    <p><span class="text-[#667085]">Alasan:</span> <span class="px-2 py-0.5 rounded text-xs bg-red-100 text-red-700">{{ $detailTidakHadir->alasan }}</span></p>
                    <p><span class="text-[#667085]">Status:</span>
                        <span class="px-2 py-0.5 rounded text-xs font-medium
                            @class([
                                'bg-green-100 text-green-700' => $detailTidakHadir->status === 'Disetujui',
                                'bg-gray-200 text-gray-600' => $detailTidakHadir->status === 'Ditolak',
                                'bg-yellow-100 text-yellow-700' => $detailTidakHadir->status === 'Menunggu',
                            ])">{{ $detailTidakHadir->status }}</span>
                    </p>
                    <div>
                        <p class="text-[#667085] mb-1">Keterangan:</p>
                        <p class="bg-[#F6F7FA] rounded p-3">{{ $detailTidakHadir->keterangan ?: 'Tidak ada keterangan tambahan.' }}</p>
                    </div>
                </div>
                @if($detailTidakHadir->status === 'Menunggu')
                    <div class="flex gap-2 mt-5">
                        <button wire:click="setujuiTidakHadir({{ $detailTidakHadir->id }})" class="flex-1 bg-green-600 text-white text-sm font-semibold rounded-lg px-4 py-2.5">Setujui</button>
                        <button wire:click="tolakTidakHadir({{ $detailTidakHadir->id }})" class="flex-1 border border-[#E5E7EB] text-sm font-semibold rounded-lg px-4 py-2.5">Tolak</button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>