<div>
    <h1 class="h-sub mb-1">Absensi Kelas</h1>
    <p class="text-sm text-[#667085] mb-6">{{ now()->translatedFormat('l, d F Y') }}</p>

    @if($error)
        <div class="bg-red-50 text-red-600 text-sm rounded-xl p-3.5 mb-5">{{ $error }}</div>
    @endif

    @if($tahap === 'daftar' || $tahap === 'ditolak')
        <div class="card-premium hover:-translate-y-0 overflow-hidden mb-5">
            <p class="text-sm font-semibold text-navy p-4 pb-2">Jadwal Mengajar Hari Ini</p>
            @if($jadwalHariIni->isEmpty())
                <p class="text-sm text-[#667085] p-4 pt-0">Tidak ada jadwal mengajar untuk hari ini.</p>
            @else
                <div class="divide-y divide-[#E5E7EB]">
                    @foreach($jadwalHariIni as $j)
                        @php
                            $sekarang = now()->format('H:i:s');
                            $bisaAkses = $sekarang >= $j->jam_mulai;
                        @endphp
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-sm">{{ $j->kelas_nama }} — {{ $j->mapel_nama }}</p>
                                <p class="text-xs text-[#667085] mt-0.5">
                                    {{ substr($j->jam_mulai,0,5) }} - {{ substr($j->jam_selesai,0,5) }}
                                    @if($j->tipe === 'pengganti')
                                        <span class="ml-1 px-1.5 py-0.5 rounded bg-blue-50 text-accent-blue text-[10px] font-semibold">PENGGANTI</span>
                                    @endif
                                    @if($bisaAkses && $sekarang > $j->jam_selesai)
                                        <span class="ml-1 px-1.5 py-0.5 rounded bg-red-50 text-red-600 text-[10px] font-semibold">SUDAH LEWAT JAM</span>
                                    @endif
                                    @if($j->diliburkan)
                                        <span class="ml-1 px-1.5 py-0.5 rounded bg-orange-50 text-orange-600 text-[10px] font-semibold">PULANG CEPAT — TIDAK WAJIB DIISI</span>
                                    @endif
                                </p>
                            </div>
                            @if($j->sudah_diisi)
                                <button wire:click="pilihJadwal('{{ $j->tipe }}', {{ $j->id }})"
                                    class="flex items-center gap-1.5 bg-green-50 text-green-700 !px-4 !py-2 text-sm rounded-lg font-semibold">
                                    ✓ Sudah Diisi
                                </button>
                            @elseif($j->tidak_hadir)
                                <span class="text-xs text-yellow-600 font-medium px-3 py-2">Sudah Lapor Tidak Hadir</span>
                            @elseif($bisaAkses)
                                <button wire:click="pilihJadwal('{{ $j->tipe }}', {{ $j->id }})"
                                    class="btn-primary !px-4 !py-2 text-sm">
                                    Isi Absensi
                                </button>
                            @else
                                <span class="text-xs text-gray-400 font-medium">Belum waktunya</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if($tahap !== 'daftar' && $tahap !== 'ditolak')
        <button wire:click="batalPilihJadwal" class="text-sm text-accent-blue mb-4">← Kembali ke daftar jadwal</button>

        <div class="bg-white border-2 border-navy/10 rounded-2xl p-4 mb-5">
            <p class="text-sm font-semibold text-navy">{{ $namaKelasTerpilih }} — {{ $namaMapelTerpilih }}</p>
            <p class="text-xs text-[#667085] mt-0.5">{{ $jamMulaiTerpilih }}@if($jamSelesaiTerpilih !== '-') - {{ $jamSelesaiTerpilih }} @endif</p>
        </div>
    @endif

    @if($tahap === 'masuk' && !$showTidakHadirForm)
        <div class="mb-4">
            <button wire:click="$set('showTidakHadirForm', true)" class="text-sm text-red-500 underline">
                Saya tidak bisa mengajar sesi ini (sakit/izin)
            </button>
        </div>
    @endif

    @if($showTidakHadirForm)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 space-y-3">
            <p class="text-sm font-semibold text-red-700">Laporkan Ketidakhadiran Mengajar</p>
            <div>
                <label class="text-sm text-[#667085]">Alasan</label>
                <select wire:model="alasanTidakHadir" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                    <option value="Dinas Luar">Dinas Luar</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Keterangan (opsional)</label>
                <textarea wire:model="keteranganTidakHadir" rows="2" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
            <div class="flex gap-2">
                <button wire:click="simpanTidakHadir" class="bg-red-600 text-white px-4 py-2 rounded text-sm font-semibold">Kirim Laporan</button>
                <button wire:click="$set('showTidakHadirForm', false)" class="border border-[#E5E7EB] px-4 py-2 rounded text-sm">Batal</button>
            </div>
        </div>
    @endif

    @if($tahap === 'tidak_hadir')
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg p-4 mb-4">
            <p>Kamu sudah melaporkan tidak bisa mengajar sesi ini.</p>
            <p class="mt-2 text-xs font-semibold">
                Status:
                @if($statusTidakHadirTersimpan === 'Disetujui')
                    <span class="text-green-700">Disetujui admin</span>
                @elseif($statusTidakHadirTersimpan === 'Ditolak')
                    <span class="text-red-600">Ditolak admin — hubungi kepala sekolah</span>
                @else
                    <span class="text-yellow-700">Menunggu persetujuan admin</span>
                @endif
            </p>
        </div>
    @endif

    @if($tahap === 'masuk' && !$showTidakHadirForm)
        @if($siswaList->count())
            <div class="card-premium hover:-translate-y-0 overflow-hidden mb-5">
                <div class="flex items-center justify-between p-4 pb-0">
                    <p class="text-sm font-semibold text-navy">Isi Kehadiran ({{ $siswaList->count() }} siswa)</p>
                    <button type="button" wire:click="tandaiSemuaHadir" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 border border-emerald-200 hover:bg-emerald-50 rounded-lg px-3 py-1.5 transition-colors">
                        Tandai Semua Hadir
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm mt-2">
                        <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                            <tr>
                                <th class="p-3 w-12">No</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaList as $i => $s)
                                <tr class="border-t border-[#E5E7EB]">
                                    <td class="p-3 text-[#667085]">{{ $i + 1 }}</td>
                                    <td class="p-3">{{ $s->nama }}</td>
                                    <td class="p-3">
                                        @php
                                            $current = $status[$s->id] ?? 'Hadir';
                                            $opsi = [
                                                'Hadir' => ['icon' => '✓', 'bg' => 'bg-green-600'],
                                                'Izin' => ['icon' => 'I', 'bg' => 'bg-yellow-500'],
                                                'Sakit' => ['icon' => 'S', 'bg' => 'bg-orange-500'],
                                                'Alpha' => ['icon' => '✕', 'bg' => 'bg-red-600'],
                                            ];
                                        @endphp
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($opsi as $label => $conf)
                                                <button type="button" wire:click="$set('status.{{ $s->id }}', '{{ $label }}')"
                                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold border transition-all
                                                        {{ $current === $label
                                                            ? $conf['bg'].' text-white border-transparent shadow-sm'
                                                            : 'bg-white text-[#667085] border-[#E5E7EB] hover:border-accent-blue hover:text-accent-blue' }}">
                                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-[10px]
                                                        {{ $current === $label ? 'bg-white/25' : 'bg-[#F6F7FA]' }}">{{ $conf['icon'] }}</span>
                                                    {{ $label }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-premium hover:-translate-y-0 p-5 mb-5 space-y-4">
                <p class="text-sm font-semibold text-navy">Jurnal Mengajar</p>
                <div>
                    <label class="text-xs text-[#667085]">Materi yang Diajarkan</label>
                    <textarea wire:model="materi" rows="2" placeholder="Contoh: Bab 3 - Penjumlahan Pecahan" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm mt-1"></textarea>
                    @error('materi')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="text-xs text-[#667085]">Kegiatan / Metode Pembelajaran</label>
                    <textarea wire:model="kegiatan" rows="2" placeholder="Contoh: Diskusi kelompok, praktik soal" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm mt-1"></textarea>
                    @error('kegiatan')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="text-xs text-[#667085]">Kendala / Catatan Tambahan (opsional)</label>
                    <textarea wire:model="kendala" rows="2" placeholder="Contoh: Proyektor rusak, siswa kurang fokus" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm mt-1"></textarea>
                </div>
            </div>

            <button type="button" wire:click="submit" wire:loading.attr="disabled" wire:target="submit"
                class="w-full bg-navy text-white px-6 py-4 rounded-lg text-base font-bold disabled:opacity-40 disabled:cursor-not-allowed hover:bg-navy-dark transition-colors">
                <span wire:loading.remove wire:target="submit">Simpan Absensi</span>
                <span wire:loading wire:target="submit">Menyimpan...</span>
            </button>
        @else
            <p class="text-sm text-[#667085]">Tidak ada siswa aktif di kelas ini.</p>
        @endif
    @endif

    @if($tahap === 'lengkap')
        <div class="bg-green-50 text-green-700 text-sm rounded-xl p-3.5 mb-4">
            ✓ Absensi sesi ini sudah tersimpan.
        </div>

        <div class="card-premium hover:-translate-y-0 overflow-hidden mb-5">
            <div class="flex items-center justify-between p-4 pb-2">
                <p class="text-sm font-semibold text-navy">Rekap Kehadiran</p>
                @if($bisaEdit)
                    <button type="button" wire:click="$set('modeEdit', {{ $modeEdit ? 'false' : 'true' }})" class="text-xs font-semibold text-accent-blue">
                        {{ $modeEdit ? 'Selesai Meralat' : 'Ralat Kehadiran' }}
                    </button>
                @else
                    <span class="text-[10px] text-[#667085]">Batas ralat 15 menit sudah lewat</span>
                @endif
            </div>
            <div class="divide-y divide-[#E5E7EB]">
                @foreach($siswaList as $s)
                    @php
                        $current = $status[$s->id] ?? '-';
                        $warna = [
                            'Hadir' => 'bg-green-50 text-green-700',
                            'Izin' => 'bg-yellow-50 text-yellow-700',
                            'Sakit' => 'bg-orange-50 text-orange-700',
                            'Alpha' => 'bg-red-50 text-red-600',
                        ][$current] ?? 'bg-gray-50 text-gray-500';
                    @endphp
                    <div class="px-4 py-2.5 flex items-center justify-between text-sm">
                        <span>{{ $s->nama }}</span>
                        @if($modeEdit && $bisaEdit)
                            <div class="flex flex-wrap gap-1.5 justify-end">
                                @foreach(['Hadir', 'Izin', 'Sakit', 'Alpha'] as $label)
                                    <button type="button" wire:click="updateStatusSiswa({{ $s->id }}, '{{ $label }}')"
                                        class="px-2.5 py-1 rounded-full text-[11px] font-semibold border
                                            {{ $current === $label ? 'bg-navy text-white border-navy' : 'bg-white text-[#667085] border-[#E5E7EB] hover:border-accent-blue' }}">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $warna }}">{{ $current }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card-premium hover:-translate-y-0 p-5 mb-5 space-y-4">
            <p class="text-sm font-semibold text-navy">Jurnal Mengajar</p>
            <div>
                <label class="text-xs text-[#667085]">Materi yang Diajarkan</label>
                <textarea wire:model="materi" wire:change="simpanJurnal" rows="2" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm mt-1"></textarea>
                @error('materi')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="text-xs text-[#667085]">Kegiatan / Metode Pembelajaran</label>
                <textarea wire:model="kegiatan" wire:change="simpanJurnal" rows="2" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm mt-1"></textarea>
                @error('kegiatan')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="text-xs text-[#667085]">Kendala / Catatan Tambahan</label>
                <textarea wire:model="kendala" wire:change="simpanJurnal" rows="2" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm mt-1"></textarea>
            </div>
            <p class="text-[11px] text-[#667085]">Perubahan jurnal tersimpan otomatis.</p>
        </div>

        <div class="card-premium hover:-translate-y-0 p-5 mb-5">
            @if($waktuSelesai)
                <div class="flex items-center gap-2.5 text-emerald-700 bg-emerald-50 rounded-xl p-3.5 text-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Sesi ini sudah ditandai selesai pukul {{ \Illuminate\Support\Carbon::parse($waktuSelesai)->format('H:i') }}.
                </div>
            @else
                <p class="text-sm font-semibold text-navy mb-1">Sudah selesai mengajar?</p>
                <p class="text-xs text-[#667085] mb-3.5">Tandai sesi ini selesai supaya statusnya update dari "Sedang Mengajar" di dashboard.</p>
                <button type="button" wire:click="selesaiMengajar" wire:loading.attr="disabled" wire:target="selesaiMengajar"
                    class="w-full bg-navy text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-accent-blue transition-colors">
                    <span wire:loading.remove wire:target="selesaiMengajar">Tandai Selesai Mengajar</span>
                    <span wire:loading wire:target="selesaiMengajar">Menyimpan...</span>
                </button>
            @endif
        </div>
    @endif
</div>