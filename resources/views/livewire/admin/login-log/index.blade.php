<div>
    <h1 class="text-xl font-extrabold text-navy tracking-tight mb-6">Log Login</h1>

    <div class="grid grid-cols-2 gap-4 mb-6 max-w-md">
        <div class="card-premium p-5">
            <p class="text-2xl font-extrabold text-navy">{{ $totalBerhasil }}</p>
            <p class="text-xs text-[#667085] mt-1">Login Berhasil (30 Hari)</p>
        </div>
        <div class="card-premium p-5">
            <p class="text-2xl font-extrabold text-red-500">{{ $totalGagal }}</p>
            <p class="text-xs text-[#667085] mt-1">Login Gagal (30 Hari)</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    @if($ipDiblokir->isNotEmpty())
        <div class="card-premium p-5 mb-6 border-2 border-red-100">
            <p class="text-sm font-bold text-red-600 mb-3">🚫 IP Sedang Diblokir ({{ $ipDiblokir->count() }})</p>
            <div class="space-y-2">
                @foreach($ipDiblokir as $b)
                    <div class="flex justify-between items-center text-sm bg-red-50 rounded-lg px-3 py-2">
                        <div>
                            <p class="font-semibold text-navy">{{ $b->ip_address }}</p>
                            <p class="text-xs text-[#667085]">{{ $b->alasan }} · {{ $b->diblokir_pada->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                        @can('kelola-data')
                            <button wire:click="bukaBlokir({{ $b->id }})" wire:confirm="Buka blokir untuk IP {{ $b->ip_address }}?" class="btn-secondary text-xs !px-3 !py-1.5">Buka Blokir</button>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="flex flex-wrap gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari email..."
            class="border border-[#E5E7EB] rounded px-3 py-2 text-sm w-full max-w-xs">
        <select wire:model.live="filterStatus" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
            <option value="">Semua Status</option>
            <option value="Berhasil">Berhasil</option>
            <option value="Gagal">Gagal</option>
        </select>
    </div>

    <div class="card-premium overflow-hidden hover:-translate-y-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                    <tr>
                        <th class="p-3">Waktu</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">IP Address</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-t border-[#E5E7EB]">
                            <td class="p-3 text-[#667085]">{{ $log->waktu->translatedFormat('d M Y, H:i') }}</td>
                            <td class="p-3 font-medium text-navy">{{ $log->user->name ?? '-' }}</td>
                            <td class="p-3">{{ $log->email }}</td>
                            <td class="p-3 text-[#667085]">
                                {{ $log->ip_address ?? '-' }}
                                @if($log->ip_address && in_array($log->ip_address, $ipDiblokirList))
                                    <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600">DIBLOKIR</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $log->status === 'Berhasil' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600' }}">
                                    {{ $log->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-[#667085]">Belum ada log login.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $logs->links() }}</div>
</div>