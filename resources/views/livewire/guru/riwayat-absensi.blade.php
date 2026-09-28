<div>
    <h1 class="h-sub mb-1">Riwayat Kehadiran Siswa</h1>
    <p class="text-sm text-[#667085] mb-4">Rekap kehadiran siswa pada mata pelajaran yang kamu ajar</p>

    @if($kelasSaya->isEmpty())
        <div class="bg-yellow-50 text-yellow-700 text-sm rounded-xl p-4">Kamu belum punya jadwal mengajar di kelas manapun.</div>
    @else
        <div class="flex gap-2 items-center mb-4 flex-wrap">
            <select wire:model.live="kelasId" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                @foreach($kelasSaya as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            <select wire:model.live="bulan" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                @foreach(range(1,12) as $b)
                    <option value="{{ $b }}">{{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="tahun" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
                @foreach(range(now()->year, now()->year - 2) as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="card-premium hover:-translate-y-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3 text-center">Hadir</th>
                            <th class="p-3 text-center">Izin</th>
                            <th class="p-3 text-center">Sakit</th>
                            <th class="p-3 text-center">Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekap as $r)
                            <tr class="border-t border-[#E5E7EB] {{ $r->alpha >= 3 ? 'bg-red-50' : '' }}">
                                <td class="p-3">{{ $r->nama }}</td>
                                <td class="p-3 text-center text-green-700">{{ $r->hadir }}</td>
                                <td class="p-3 text-center text-yellow-700">{{ $r->izin }}</td>
                                <td class="p-3 text-center text-orange-700">{{ $r->sakit }}</td>
                                <td class="p-3 text-center text-red-600 font-semibold">{{ $r->alpha }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>