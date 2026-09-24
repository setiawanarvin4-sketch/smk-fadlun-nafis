<x-layouts.admin>
    <div class="flex flex-wrap justify-between items-center gap-3 mb-4 print:hidden">
        <h1 class="text-xl font-extrabold text-navy tracking-tight">Cetak Kartu Akses Portal Siswa</h1>
        <div class="flex items-center gap-3">
            <form method="GET">
                <select name="kelas" onchange="this.form.submit()" class="border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" @selected($kelasFilter == $k->id)>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </form>
            <button onclick="window.print()" class="btn-primary">Cetak / Simpan PDF</button>
        </div>
    </div>

    @php
        $query = \App\Models\Siswa::with('kelas')->where('aktif', true)->whereNotNull('user_id')
            ->when($kelasFilter, fn ($q) => $q->where('kelas_id', $kelasFilter))
            ->orderBy('kelas_id')->orderBy('nama');
        $siswaList = $query->get();
        $belumPunyaAkun = \App\Models\Siswa::where('aktif', true)->whereNull('user_id')
            ->when($kelasFilter, fn ($q) => $q->where('kelas_id', $kelasFilter))
            ->count();
    @endphp

    @if($belumPunyaAkun > 0)
        <div class="bg-amber-50 text-amber-700 text-sm rounded-xl p-3.5 mb-4 print:hidden">
            Ada {{ $belumPunyaAkun }} siswa (di filter ini) yang belum punya akun, jadi tidak ikut tercetak. Buatkan dulu akunnya lewat menu Siswa.
        </div>
    @endif

    <div id="area-cetak" class="bg-white p-8 print:p-0">
        <div class="text-center mb-6 pb-4 border-b-2 border-navy">
            <p class="font-bold text-navy text-lg">Kartu Akses Portal Siswa</p>
            <p class="text-sm text-[#667085]">SMK Fadlun Nafis Bangsri — {{ now()->translatedFormat('d F Y') }}</p>
        </div>

        <p class="text-xs text-[#667085] mb-4">
            Login di: <strong>{{ url('/portal-siswa/portal-akses') }}</strong>.
            Password di bawah adalah <strong>password awal</strong> — kalau siswa/wali sudah pernah menggantinya sendiri lewat menu "Ganti Password", password ini tidak berlaku lagi.
        </p>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-navy text-left">
                    <th class="py-2 pr-2">No</th>
                    <th class="py-2 pr-2">Nama</th>
                    <th class="py-2 pr-2">Kelas</th>
                    <th class="py-2 pr-2">NIS (Username)</th>
                    <th class="py-2 pr-2">Password Awal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswaList as $i => $s)
                    <tr class="border-b border-[#E5E7EB]">
                        <td class="py-1.5 pr-2">{{ $i + 1 }}</td>
                        <td class="py-1.5 pr-2">{{ $s->nama }}</td>
                        <td class="py-1.5 pr-2">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td class="py-1.5 pr-2">{{ $s->nis }}</td>
                        <td class="py-1.5 pr-2">{{ $s->nisn ?: $s->nis }}</td>
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