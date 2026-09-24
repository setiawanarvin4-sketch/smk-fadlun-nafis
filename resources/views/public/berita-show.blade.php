<?php $__berita = \App\Models\Berita::where('slug', $slug)->first(); ?>
<x-layouts.public
    :title="$__berita->seo_title ?: ($__berita->judul ?? 'Berita')"
    :description="$__berita->seo_description ?: ($__berita->ringkasan ?? null)"
    :image="$__berita?->thumbnail ? asset('storage/'.$__berita->thumbnail) : null">
    @livewire('public.berita.show', ['slug' => $slug])
</x-layouts.public>