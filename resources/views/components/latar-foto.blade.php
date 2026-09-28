@props(['foto' => null])

@if($foto)
    {{-- Foto sekolah + lapisan gelap. md:bg-fixed = efek parallax di desktop (hapus kalau tidak mau) --}}
    <div class="absolute inset-0 bg-cover bg-center md:bg-fixed"
         style="background-image: url('{{ asset('storage/'.$foto) }}')"></div>
    <div class="absolute inset-0 bg-black/55"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-navy/60 via-transparent to-navy/30"></div>
@else
    {{-- Cadangan kalau belum ada foto sama sekali: gradient navy polos, tanpa garis --}}
    <div class="absolute inset-0 bg-gradient-to-br from-navy to-navy-dark"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent-teal/10 rounded-full blur-3xl animate-blob"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-accent-blue/10 rounded-full blur-3xl animate-blob" style="animation-delay:2s"></div>
@endif