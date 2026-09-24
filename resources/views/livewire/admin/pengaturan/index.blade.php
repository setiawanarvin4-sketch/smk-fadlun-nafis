<div>
    <h1 class="text-xl font-extrabold text-navy tracking-tight mb-6">Pengaturan Website</h1>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded-xl p-3.5 mb-6">{{ session('success') }}</div>
    @endif

    <form wire:submit="save" class="space-y-5 max-w-2xl">
        <!-- IDENTITAS -->
        <div class="card-premium p-6 space-y-4 hover:-translate-y-0">
            <p class="h-eyebrow">Identitas</p>
            <p class="text-sm font-bold text-navy -mt-2">Identitas Sekolah</p>
            <div>
                <label class="text-sm text-[#667085]">Logo</label>
                @if($pengaturan->logo)
                    <img src="{{ asset('storage/'.$pengaturan->logo) }}" class="w-16 h-16 rounded-xl object-cover border border-[#E5E7EB] mt-1 mb-2">
                @endif
                <input type="file" wire:model="logo" accept="image/*" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm">
                <div wire:loading wire:target="logo" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Nama Sekolah</label>
                <input type="text" wire:model="nama_sekolah" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                @error('nama_sekolah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-sm text-[#667085]">Tagline</label>
                <input type="text" wire:model="tagline" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        <!-- KONTAK -->
        <div class="card-premium p-6 space-y-4 hover:-translate-y-0">
            <p class="h-eyebrow">Kontak</p>
            <p class="text-sm font-bold text-navy -mt-2">Informasi Kontak</p>
            <div>
                <label class="text-sm text-[#667085]">Alamat</label>
                <textarea wire:model="alamat" rows="2" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm text-[#667085]">Telepon</label>
                    <input type="text" wire:model="telepon" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm text-[#667085]">WhatsApp (format: 628xxxx)</label>
                    <input type="text" wire:model="whatsapp" placeholder="628123456789" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                </div>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Email</label>
                <input type="email" wire:model="email" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm text-[#667085]">Instagram (link lengkap)</label>
                    <input type="text" wire:model="instagram" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm text-[#667085]">Facebook (link lengkap)</label>
                    <input type="text" wire:model="facebook" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm text-[#667085]">YouTube (link lengkap)</label>
                    <input type="text" wire:model="youtube" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm text-[#667085]">TikTok (link lengkap)</label>
                    <input type="text" wire:model="tiktok" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                </div>
            </div>
        </div>

        <!-- LOKASI -->
        <div class="card-premium p-6 space-y-4 hover:-translate-y-0">
            <p class="h-eyebrow">Lokasi</p>
            <p class="text-sm font-bold text-navy -mt-2">Lokasi (Google Maps)</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm text-[#667085]">Latitude</label>
                    <input type="text" wire:model="latitude" placeholder="-6.5952" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                    @error('latitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="text-sm text-[#667085]">Longitude</label>
                    <input type="text" wire:model="longitude" placeholder="110.7256" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                    @error('longitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <p class="text-xs text-[#667085]">Tips: buka Google Maps, klik kanan lokasi sekolah, koordinat akan muncul di menu yang tampil.</p>
        </div>

        <!-- PPDB -->
        <div class="card-premium p-6 space-y-4 hover:-translate-y-0">
            <p class="h-eyebrow">PPDB</p>
            <p class="text-sm font-bold text-navy -mt-2">Pendaftaran</p>
            <div>
                <label class="text-sm text-[#667085]">Link PPDB Resmi</label>
                <input type="text" wire:model="link_ppdb" placeholder="https://ppdb.smkfadlunnafis.sch.id" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        <!-- RETENSI SELFIE dihapus: fitur verifikasi selfie sudah tidak dipakai lagi
             sejak Portal Guru disederhanakan jadi check-in tanpa foto. -->

        <!-- MAINTENANCE -->
        <div class="card-premium p-6 hover:-translate-y-0">
            <label class="flex items-center gap-2 text-sm font-bold text-navy">
                <input type="checkbox" wire:model="maintenance_mode">
                Aktifkan Mode Maintenance
            </label>
            <p class="text-xs text-[#667085] mt-1">Kalau aktif, pengunjung publik akan melihat halaman "Website sedang dalam pemeliharaan". Admin tetap bisa login seperti biasa.</p>
        </div>

        <!-- NOTIFIKASI WHATSAPP -->
        <div class="card-premium p-6 hover:-translate-y-0 space-y-4">
            <div>
                <label class="flex items-center gap-2 text-sm font-bold text-navy">
                    <input type="checkbox" wire:model="wa_notifikasi_aktif">
                    Aktifkan Notifikasi WhatsApp ke Wali Murid
                </label>
                <p class="text-xs text-[#667085] mt-1">Kalau aktif, wali murid otomatis dapat pesan WhatsApp saat anaknya ditandai <strong>Alpha</strong> oleh guru. Butuh akun gateway WhatsApp pihak ketiga (contoh: Fonnte) — bukan WhatsApp pribadi kamu.</p>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Token API Gateway</label>
                <input type="text" wire:model="wa_gateway_token" placeholder="Token dari dashboard provider WA gateway kamu" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm text-[#667085]">URL Endpoint Gateway</label>
                <input type="text" wire:model="wa_gateway_endpoint" placeholder="https://api.fonnte.com/send" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                <p class="text-xs text-[#667085] mt-1">Kosongkan / nonaktifkan kalau belum punya akun gateway WA — fitur ini tidak akan mengganggu proses absensi biasa walau belum diisi.</p>
            </div>
        </div>

        <button type="submit" class="btn-primary">Simpan Pengaturan</button>
    </form>
</div>