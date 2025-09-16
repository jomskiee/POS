@php
    $breadcrumbs = [
        ['title' => 'Fish Boxes']
    ];
@endphp

@extends('layouts.broker')

@section('content')
<link rel="stylesheet" href="{{ asset('css/filter-layout.css') }}">
<!-- Meta tags for QR scanner functionality -->
<meta name="fish-box-update-url" content="{{ route('broker.fish-boxes.update-status') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="w-full content-spacing">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Fish Boxes</h1>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">Return and track your assigned fish boxes</p>
            </div>
            <div class="flex space-x-3">
                <!-- Camera QR Scanner Button -->
                <button id="scanQRBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center w-full sm:w-auto">
                    <x-heroicon-o-camera class="w-4 h-4 mr-2" />
                    Scan QR to Return
                </button>

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
            <div class="filter-layout">
                <!-- Search Field -->
                <div class="search-field">
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
                <div class="status-field">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" x-model="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        @foreach($fishBoxStatuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fish Type Filter -->
                <div class="fish-type-field">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fish Type</label>
                    <select name="fish_type" x-model="fishType" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Fish Types</option>
                        @foreach($fishTypes as $fishType)
                            <option value="{{ $fishType->id }}" {{ request('fish_type') == $fishType->id ? 'selected' : '' }}>
                                {{ $fishType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="buttons-field flex justify-end space-x-2">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer Contact</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $fishBox->buyer_names }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $fishBox->buyer_contacts }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $fishBox->fishType->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $fishBox->status === 'In Stock' ? 'bg-green-100 text-green-800' : ($fishBox->status === 'Sold' ? 'bg-blue-100 text-blue-800' : ($fishBox->status === 'Returned' ? 'bg-yellow-100 text-yellow-800' : ($fishBox->status === 'Missing' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                    {{ $fishBox->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $fishBox->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @if($fishBox->canBeMarkedAsMissing())
                                        <form method="POST" action="/broker/fish-boxes/{{ $fishBox->id }}/mark-missing"
                                              data-swal="mark-missing"
                                              data-record-name="{{ $fishBox->name }}"
                                              class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Mark as Missing">
                                                <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
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

<script src="{{ asset('js/qr-scanner.js') }}" defer></script>
<script src="{{ asset('js/qr-backend-handler.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize QR Scanner
    window.qrScanner = new QRScanner();
    window.qrBackendHandler = new QRBackendHandler();

    // Initialize backend handler
    if (window.qrBackendHandler.initialize()) {
        // QR Backend Handler initialized successfully
    }

    // Setup QR scanner button event listener
    const scanQRBtn = document.getElementById('scanQRBtn');
    if (scanQRBtn) {
        scanQRBtn.addEventListener('click', function() {
            if (window.qrScanner) {
                window.qrScanner.openModal();
                setTimeout(() => {
                    window.qrScanner.startScanner();
                }, 100);
            } else {
                alert('QR Scanner not initialized. Please refresh the page.');
            }
        });
    }
});
</script>

@endsection
