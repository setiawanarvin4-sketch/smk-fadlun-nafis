<x-layouts.admin>
    <div class="flex justify-between items-center mb-4 print:hidden">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Cetak Data Guru</h1>
        <button onclick="window.print()" class="btn-primary">Cetak / Simpan PDF</button>
    </div>

    <div id="area-cetak" class="bg-white p-8 print:p-0">
        <div class="text-center mb-6 pb-4 border-b-2 border-navy">
            <p class="font-bold text-navy text-lg">Data Guru & Tenaga Kependidikan</p>
            <p class="text-sm text-[#667085]">SMK Fadlun Nafis Bangsri — {{ now()->translatedFormat('d F Y') }}</p>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-navy text-left">
                    <th class="py-2 pr-2">No</th>
                    <th class="py-2 pr-2">Nama</th>
                    <th class="py-2 pr-2">NIG</th>
                    <th class="py-2 pr-2">Jabatan</th>
                    <th class="py-2 pr-2">Bidang</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Guru::where('aktif', true)->orderBy('nama')->get() as $i => $g)
                    <tr class="border-b border-[#E5E7EB]">
                        <td class="py-1.5 pr-2">{{ $i + 1 }}</td>
                        <td class="py-1.5 pr-2">{{ $g->nama }}</td>
                        <td class="py-1.5 pr-2">{{ $g->nip }}</td>
                        <td class="py-1.5 pr-2">{{ $g->jabatan ?? '-' }}</td>
                        <td class="py-1.5 pr-2">{{ $g->bidang ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-16 flex justify-end">
            <div class="text-center text-sm">
                <p>Bangsri, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="mb-16 mt-1">Kepala Sekolah,</p>
                <p class="font-semibold border-t border-navy pt-1 inline-block px-8">&nbsp;</p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; }
            #area-cetak, #area-cetak * { visibility: visible; }
            #area-cetak { position: absolute; top: 0; left: 0; width: 100%; }
        }
    </style>
</x-layouts.admin>