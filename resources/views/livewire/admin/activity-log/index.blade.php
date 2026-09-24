<div>
    <h1 class="text-xl font-semibold text-navy mb-4">Log Aktivitas</h1>

    <div class="flex flex-wrap gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari aktivitas..."
            class="border border-[#E5E7EB] rounded px-3 py-2 text-sm w-full max-w-xs">
        <select wire:model.live="filterModul" class="border border-[#E5E7EB] rounded px-3 py-2 text-sm">
            <option value="">Semua Modul</option>
            @foreach($modulList as $m)
                <option value="{{ $m }}">{{ $m }}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                <tr>
                    <th class="p-3">Waktu</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Aktivitas</th>
                    <th class="p-3">Modul</th>
                    <th class="p-3">IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t border-[#E5E7EB]">
                        <td class="p-3 text-[#667085] whitespace-nowrap">{{ $item->created_at->diffForHumans() }}</td>
                        <td class="p-3">{{ $item->user->name ?? 'Sistem' }}</td>
                        <td class="p-3">{{ $item->aktivitas }}</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded text-xs bg-light-blue text-accent-blue">{{ $item->modul ?? '-' }}</span>
                        </td>
                        <td class="p-3 text-[#667085]">{{ $item->ip_address ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-6 text-center text-[#667085]">Belum ada log aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
</div>