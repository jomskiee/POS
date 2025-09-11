@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'Sales Management']
    ];
@endphp

<div class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: true }">
    <!-- Broker Sidebar Component -->
    @include('layouts.partials.broker-sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out" :style="sidebarOpen ? 'margin-left: 16rem;' : 'margin-left: 4rem;'">
        <!-- Broker Navbar Component -->
        @include('layouts.partials.broker-navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Fish Boxes</h1>
                            <p class="text-gray-600 mt-2">Track your fish boxes</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('broker.sales.sales') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View Sales
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fish Box Filters -->
                <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                    <form method="GET" action="{{ route('broker.sales.fish-boxes') }}" x-data="{
                        search: '{{ request('search') }}',
                        status: '{{ request('status') }}',
                        fishType: '{{ request('fish_type') }}'
                    }">
                        <div class="grid grid-cols-12 gap-4 items-end">
                            <!-- Search Field -->
                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <div class="relative">
                                    <input type="text"
                                        name="search"
                                        x-model="search"
                                        placeholder="Search fish box name, QR code, or fish type..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                                    </div>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" x-model="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Status</option>
                                    @foreach(\App\Constants\FishBoxStatusConstant::getAllStatuses() as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fish Type Filter -->
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fish Type</label>
                                <select name="fish_type" x-model="fishType" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Fish Types</option>
                                    @foreach(\App\Models\FishType::all() as $fishType)
                                        <option value="{{ $fishType->id }}" {{ request('fish_type') == $fishType->id ? 'selected' : '' }}>
                                            {{ $fishType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-span-12 md:col-span-4 flex justify-end space-x-2">
                                <a href="{{ route('broker.sales.fish-boxes') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    Clear
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results Count -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        Showing {{ $fishBoxes->firstItem() ?? 0 }} to {{ $fishBoxes->lastItem() ?? 0 }} of {{ $fishBoxes->total() }} fish boxes
                        @if(request()->hasAny(['search', 'status', 'fish_type']))
                            <span class="text-blue-600">(filtered)</span>
                        @endif
                    </p>
                </div>

                <!-- Fish Boxes Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fish Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($fishBoxes as $fishBox)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $fishBox->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <code class="text-xs bg-gray-100 px-2 py-1 rounded font-mono">{{ Str::limit($fishBox->qr_code, 20) }}</code>
                                                <button onclick="copyToClipboard('{{ $fishBox->qr_code }}')"
                                                        class="ml-2 text-gray-400 hover:text-gray-600 transition-colors"
                                                        title="Copy QR Code">
                                                    <x-heroicon-o-clipboard class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $fishBox->fishType->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $fishBox->status === 'In Stock' ? 'bg-green-100 text-green-800' : ($fishBox->status === 'Sold' ? 'bg-blue-100 text-blue-800' : ($fishBox->status === 'Returned' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ $fishBox->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $fishBox->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="showQRCode('{{ $fishBox->qr_code }}', '{{ $fishBox->name }}')"
                                                        class="text-blue-600 hover:text-blue-900 transition-colors"
                                                        title="View QR Code">
                                                    <x-heroicon-o-qr-code class="w-5 h-5" />
                                                </button>
                                                @if($fishBox->status === 'In Stock')
                                                <button data-fish-box-id="{{ $fishBox->id }}"
                                                        class="mark-as-sold-btn text-green-600 hover:text-green-900 transition-colors"
                                                        title="Mark as Sold">
                                                    <x-heroicon-o-check-circle class="w-5 h-5" />
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <x-heroicon-o-cube class="w-16 h-16 text-gray-400 mb-4" />
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No fish boxes found</h3>
                                                <p class="text-gray-500 mb-6">You don't have any fish boxes assigned to you yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($fishBoxes->hasPages())
                    <div class="mt-8">
                        {{ $fishBoxes->appends(request()->query())->links('components.pagination') }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- QR Code Modal -->
<div id="qrModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <x-heroicon-o-qr-code class="h-6 w-6 text-blue-600" />
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2" id="qrModalTitle">QR Code</h3>
            <div class="mt-2 px-7 py-3">
                <div id="qrcode" class="flex justify-center"></div>
                <p class="text-sm text-gray-500 mt-2" id="qrModalCode"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeQrModal" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Copy QR code to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<x-heroicon-o-check class="w-4 h-4" />';
        button.classList.add('text-green-600');

        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('text-green-600');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Failed to copy QR code');
    });
}

// Show QR code modal
function showQRCode(qrCode, name) {
    document.getElementById('qrModalTitle').textContent = name + ' - QR Code';
    document.getElementById('qrModalCode').textContent = qrCode;

    // Clear previous QR code
    document.getElementById('qrcode').innerHTML = '';

    // Generate QR code (you might need to include a QR code library)
    // For now, we'll just show the text
    const qrDiv = document.getElementById('qrcode');
    qrDiv.innerHTML = `
        <div class="bg-gray-100 p-4 rounded-lg border-2 border-dashed border-gray-300">
            <div class="text-center">
                <div class="text-2xl font-mono break-all">${qrCode}</div>
                <p class="text-sm text-gray-500 mt-2">QR Code</p>
            </div>
        </div>
    `;

    document.getElementById('qrModal').classList.remove('hidden');
}

// Close QR code modal
document.getElementById('closeQrModal').addEventListener('click', function() {
    document.getElementById('qrModal').classList.add('hidden');
});

// Mark fish box as sold
function markAsSold(fishBoxId) {
    if (confirm('Are you sure you want to mark this fish box as sold?')) {
        // Create a form to submit the request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/broker/fish-boxes/${fishBoxId}/mark-sold`;

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    }
}

// Handle mark as sold button clicks
document.addEventListener('click', function(e) {
    if (e.target.closest('.mark-as-sold-btn')) {
        const fishBoxId = e.target.closest('.mark-as-sold-btn').getAttribute('data-fish-box-id');
        markAsSold(fishBoxId);
    }
});

// Close modal when clicking outside
document.getElementById('qrModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
