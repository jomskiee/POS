<!-- Movement Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
        <div class="flex items-center">
            <div class="w-8 h-8 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                <x-heroicon-o-arrow-trending-up class="w-4 h-4 md:w-6 md:h-6 text-white" />
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Stocked</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($summary['stocked']) }}</p>
                <p class="text-xs text-blue-600">Today</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
        <div class="flex items-center">
            <div class="w-8 h-8 md:w-12 md:h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                <x-heroicon-o-arrow-trending-down class="w-4 h-4 md:w-6 md:h-6 text-white" />
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Sold</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($summary['sold']) }}</p>
                <p class="text-xs text-red-600">Today</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
        <div class="flex items-center">
            <div class="w-8 h-8 md:w-12 md:h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                <x-heroicon-o-arrow-path class="w-4 h-4 md:w-6 md:h-6 text-white" />
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Returned</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($summary['returned']) }}</p>
                <p class="text-xs text-yellow-600">Today</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
        <div class="flex items-center">
            <div class="w-8 h-8 md:w-12 md:h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                <x-heroicon-o-exclamation-triangle class="w-4 h-4 md:w-6 md:h-6 text-white" />
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Missing</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($summary['missing']) }}</p>
                <p class="text-xs text-purple-600">Today</p>
            </div>
        </div>
    </div>
</div>

<!-- Movement History -->
<div class="bg-white rounded-xl shadow-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Stock Movement History</h3>
        </div>
    </div>

    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200">
        <form method="GET" action="{{ route('admin.inventory.index') }}" x-data="{ action: '{{ request('action') }}', date_from: '{{ request('date_from') }}', date_to: '{{ request('date_to') }}' }">
            <input type="hidden" name="tab" value="movement">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Action Type</label>
                    <select name="action" x-model="action" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date" name="date_from" x-model="date_from" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date" name="date_to" x-model="date_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.inventory.index', ['tab' => 'movement']) }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Clear
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- Results Count -->
    @if($inventoryLogs->hasPages() || request()->hasAny(['action', 'date_from', 'date_to']))
        <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
            <p class="text-sm text-gray-600">
                Showing {{ $inventoryLogs->firstItem() ?? 0 }} to {{ $inventoryLogs->lastItem() ?? 0 }} of {{ $inventoryLogs->total() }} movement records
                @if(request()->hasAny(['action', 'date_from', 'date_to']))
                    <span class="text-blue-600">(filtered)</span>
                @endif
            </p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fish Box</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fish Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($inventoryLogs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $log->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $log->fishBox->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $log->fish_box_id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $log->fishBox->fishType->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $actionColors = [
                                    'Stocked' => 'bg-blue-100 text-blue-800',
                                    'Sold' => 'bg-red-100 text-red-800',
                                    'Returned' => 'bg-yellow-100 text-yellow-800',
                                    'Missing' => 'bg-purple-100 text-purple-800',
                                ];
                                $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                            {{ Str::limit($log->fishBox->qr_code ?? 'N/A', 12) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->user->name ?? 'System' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <x-heroicon-o-document-text class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                            <p class="text-lg font-medium text-gray-900 mb-2">No movement records found</p>
                            <p class="text-sm">No inventory movements match your current filters.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($inventoryLogs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $inventoryLogs->appends(request()->query())->links('components.pagination') }}
        </div>
    @endif
</div>
