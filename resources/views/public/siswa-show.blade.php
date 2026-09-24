<?php $__siswa = \App\Models\Siswa::find($id); ?>
<x-layouts.public :title="$__siswa ? $__siswa->nama : 'Profil Siswa'" description="Profil siswa SMK Fadlun Nafis Bangsri.">
    <x-page-hero eyebrow="Kesiswaan" title="Profil Siswa" />
    @livewire('public.siswa.show', ['id' => $id])
</x-layouts.public>