<div>
    <h1 class="text-xl font-extrabold text-navy tracking-tight mb-1">Kenaikan Kelas</h1>
    <p class="text-sm text-[#667085] mb-6">Tahun ajaran aktif sekarang: <strong>{{ $tahunAktif }}</strong></p>

    @if($ringkasanHasil)
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-6">
            <p class="font-bold text-green-700 mb-2">✓ Kenaikan kelas berhasil diproses</p>
            <ul class="text-sm text-green-700 space-y-1">
                <li>{{ $ringkasanHasil['kelas_baru'] }} kelas baru dibuat</li>
                <li>{{ $ringkasanHasil['siswa_naik'] }} siswa naik kelas</li>
                <li>{{ $ringkasanHasil['siswa_lulus'] }} siswa diluluskan</li>
            </ul>
            <p class="text-xs text-green-600 mt-3">Cek menu Kelas untuk pastikan nama kelas baru sudah benar (kelas yang polanya tidak biasa mungkin perlu diedit manual).</p>
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-white border border-[#E5E7EB] rounded-xl p-4 text-center">
            <p class="text-xl font-extrabold text-navy">{{ $jumlahKelas10 }}</p>
            <p class="text-xs text-[#667085]">Kelas 10 saat ini</p>
        </div>
        <div class="bg-white border border-[#E5E7EB] rounded-xl p-4 text-center">
            <p class="text-xl font-extrabold text-navy">{{ $jumlahKelas11 }}</p>
            <p class="text-xs text-[#667085]">Kelas 11 saat ini</p>
        </div>
        <div class="bg-white border border-[#E5E7EB] rounded-xl p-4 text-center">
            <p class="text-xl font-extrabold text-navy">{{ $jumlahKelas12 }}</p>
            <p class="text-xs text-[#667085]">Kelas 12 saat ini</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-xl font-extrabold text-red-600">{{ $jumlahAkanLulus }}</p>
            <p class="text-xs text-red-600">Akan diluluskan</p>
        </div>
    </div>

    <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5">
        <p class="font-semibold text-navy mb-3">Proses Kenaikan Kelas &amp; Kelulusan</p>
        <p class="text-sm text-[#667085] mb-4">
            Kelas 10 → 11, Kelas 11 → 12 (kelas baru otomatis dibuat), dan Kelas 12 → otomatis ditandai <strong>Lulus</strong> (dinonaktifkan). Tindakan ini menyangkut seluruh siswa sekaligus.
        </p>
        <div class="flex items-end gap-3">
            <div>
                <label class="text-sm text-[#667085]">Tahun Ajaran Baru</label>
                <input type="text" wire:model="tahunAjaranBaru" placeholder="2027/2028" class="w-40 border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                @error('tahunAjaranBaru') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
            </div>
            <button wire:click="bukaKonfirmasi" class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold">
                Proses Kenaikan Kelas
            </button>
        </div>
    </div>

    @if($showKonfirmasi)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl">
                <p class="font-bold text-navy mb-2">⚠️ Yakin lanjutkan?</p>
                <p class="text-sm text-[#667085] mb-6">
                    Ini akan memindahkan <strong>{{ $jumlahSiswaAktif - $jumlahAkanLulus }} siswa</strong> ke kelas baru
                    dan meluluskan <strong>{{ $jumlahAkanLulus }} siswa</strong> kelas 12. Tindakan ini tidak bisa dibatalkan otomatis — pastikan data sudah benar sebelum lanjut.
                </p>
                <p class="text-xs text-amber-600 bg-amber-50 rounded-lg px-3 py-2 mb-3">
                    ⚠️ Pastikan Anda sudah membuat backup database sebelum melanjutkan. Proses ini memindahkan seluruh siswa sekaligus dan tidak bisa dibatalkan.
                </p>
                <div class="flex gap-3">
                    <button wire:click="$set('showKonfirmasi', false)" class="flex-1 border border-[#E5E7EB] rounded-lg py-2.5 text-sm font-semibold">Batal</button>
                    <button wire:click="proses" wire:loading.attr="disabled" wire:target="proses"
                    class="flex-1 bg-red-600 text-white rounded-lg py-2.5 text-sm font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="proses">Ya, Proses Sekarang</span>
                    <span wire:loading wire:target="proses">Memproses...</span>
                </button>
                </div>
            </div>
        </div>
    @endif
</div>