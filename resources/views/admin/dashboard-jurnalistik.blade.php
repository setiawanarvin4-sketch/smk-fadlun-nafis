<x-layouts.admin>
    <div class="p-2">
        <h1 class="text-xl font-extrabold text-navy tracking-tight mb-1">Selamat datang, {{ auth()->user()->nama_tampilan }}</h1>
        <p class="text-sm text-[#667085] mb-6">Kelola konten publik sekolah dari sini.</p>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <a href="{{ route('admin.berita') }}" class="card-premium p-5 text-center hover:-translate-y-0.5 transition-transform">
                <p class="text-sm font-semibold text-navy">Berita</p>
            </a>
            <a href="{{ route('admin.prestasi') }}" class="card-premium p-5 text-center hover:-translate-y-0.5 transition-transform">
                <p class="text-sm font-semibold text-navy">Prestasi</p>
            </a>
            <a href="{{ route('admin.galeri') }}" class="card-premium p-5 text-center hover:-translate-y-0.5 transition-transform">
                <p class="text-sm font-semibold text-navy">Galeri</p>
            </a>
            <a href="{{ route('admin.agenda') }}" class="card-premium p-5 text-center hover:-translate-y-0.5 transition-transform">
                <p class="text-sm font-semibold text-navy">Agenda</p>
            </a>
            <a href="{{ route('admin.hero-slider') }}" class="card-premium p-5 text-center hover:-translate-y-0.5 transition-transform">
                <p class="text-sm font-semibold text-navy">Hero Slider</p>
            </a>
        </div>
    </div>
</x-layouts.admin>