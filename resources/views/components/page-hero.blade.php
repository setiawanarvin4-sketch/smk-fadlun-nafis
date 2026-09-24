@props(['title', 'subtitle' => null, 'eyebrow' => null])

<section class="relative bg-gradient-to-br from-[#EAF2FF] via-white to-[#F3FBF7] text-navy overflow-hidden border-b border-[#E5E7EB]">
    @if($profilHero->header_gambar ?? false)
        <img src="{{ asset('storage/'.$profilHero->header_gambar) }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
    @else
        <div class="absolute -top-20 -right-16 w-80 h-80 bg-accent-blue/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-20 w-72 h-72 bg-emerald-400/10 rounded-full blur-3xl"></div>
        <svg class="absolute inset-0 w-full h-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg"><pattern id="ph-grid" width="32" height="32" patternUnits="userSpaceOnUse"><path d="M32 0H0V32" fill="none" stroke="#16211C" stroke-width="1"/></pattern><rect width="100%" height="100%" fill="url(#ph-grid)"/></svg>
    @endif

    <div class="relative max-w-[1100px] mx-auto px-4 pt-32 pb-16 text-center {{ ($profilHero->header_gambar ?? false) ? 'text-white' : 'text-navy' }}">
        @if($eyebrow)
            <p class="text-xs font-bold tracking-[0.18em] uppercase {{ ($profilHero->header_gambar ?? false) ? 'text-white/80' : 'text-accent-blue' }} mb-3">{{ $eyebrow }}</p>
        @endif
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-3">{{ $title }}</h1>
        <div class="w-10 h-px bg-emerald-500 mx-auto mb-3"></div>
        @if($subtitle)
            <p class="text-sm max-w-md mx-auto {{ ($profilHero->header_gambar ?? false) ? 'text-white/75' : 'text-[#667085]' }}">{{ $subtitle }}</p>
        @endif
    </div>
</section>