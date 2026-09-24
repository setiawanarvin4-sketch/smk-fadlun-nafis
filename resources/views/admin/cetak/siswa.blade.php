<x-layouts.admin>
    <div class="flex justify-between items-center mb-4 print:hidden">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Cetak Data Siswa</h1>
        <button onclick="window.print()" class="btn-primary">Cetak / Simpan PDF</button>
    </div>

    <div id="area-cetak" class="bg-white p-8 print:p-0">
        <div class="text-center mb-6 pb-4 border-b-2 border-navy">
            <p class="font-bold text-navy text-lg">Data Siswa</p>
            <p class="text-sm text-[#667085]">SMK Fadlun Nafis Bangsri — {{ now()->translatedFormat('d F Y') }}</p>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-navy text-left">
                    <th class="py-2 pr-2">No</th>
                    <th class="py-2 pr-2">Nama</th>
                    <th class="py-2 pr-2">NIS</th>
                    <th class="py-2 pr-2">NISN</th>
                    <th class="py-2 pr-2">Kelas</th>
                    <th class="py-2 pr-2">Kompetensi</th>
                    <th class="py-2 pr-2">JK</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Siswa::with('kelas', 'kompetensi')->where('aktif', true)->orderBy('nama')->get() as $i => $s)
                    <tr class="border-b border-[#E5E7EB]">
                        <td class="py-1.5 pr-2">{{ $i + 1 }}</td>
                        <td class="py-1.5 pr-2">{{ $s->nama }}</td>
                        <td class="py-1.5 pr-2">{{ $s->nis }}</td>
                        <td class="py-1.5 pr-2">{{ $s->nisn }}</td>
                        <td class="py-1.5 pr-2">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td class="py-1.5 pr-2">{{ $s->kompetensi->nama ?? '-' }}</td>
                        <td class="py-1.5 pr-2">{{ $s->jenis_kelamin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; }
            #area-cetak, #area-cetak * { visibility: visible; }
            #area-cetak { position: absolute; top: 0; left: 0; width: 100%; }
        }
    </style>
</x-layouts.admin>