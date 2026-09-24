<x-layouts.siswa>
    <h1 class="h-section mb-6">Jadwal Pelajaran</h1>

    <div x-data="{ hari: '{{ $jadwal->keys()->first() ?? 'Senin' }}' }">
        <div class="flex gap-2 mb-5 overflow-x-auto scrollbar-hide">
            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                <button @click="hari = '{{ $h }}'"
                    :class="hari === '{{ $h }}' ? 'bg-navy text-white' : 'bg-white text-[#667085] border border-[#E5E7EB]'"
                    class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                    {{ $h }}
                </button>
            @endforeach
        </div>

        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
            <div x-show="hari === '{{ $h }}'" x-cloak class="card-premium overflow-hidden">
                @forelse($jadwal[$h] ?? [] as $j)
                    <div class="flex items-center gap-4 p-4 {{ !$loop->last ? 'border-b border-[#E5E7EB]' : '' }}">
                        <div class="text-center flex-shrink-0 w-16">
                            <p class="text-sm font-bold text-navy">{{ \Illuminate\Support\Carbon::parse($j->jam_mulai)->format('H:i') }}</p>
                            <p class="text-xs text-[#98A2B3]">{{ \Illuminate\Support\Carbon::parse($j->jam_selesai)->format('H:i') }}</p>
                        </div>
                        <div class="w-px self-stretch bg-[#E5E7EB]"></div>
                        <div>
                            <p class="font-semibold text-sm text-navy">{{ $j->mataPelajaran->nama ?? '-' }}</p>
                            <p class="text-xs text-[#667085] mt-0.5">{{ $j->guru->nama ?? '-' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="p-8 text-center text-sm text-[#98A2B3]">Tidak ada jadwal pelajaran di hari {{ $h }}.</p>
                @endforelse
            </div>
        @endforeach
    </div>
</x-layouts.siswa>