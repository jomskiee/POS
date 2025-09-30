@extends('layouts.broker')

@php
    $breadcrumbs = [
        ['title' => 'Fishboxes Management']
    ];
@endphp

@section('content')
<!-- Meta tags for QR scanner functionality -->
<meta name="fish-box-update-url" content="{{ route('broker.fish-boxes.return-via-qr') }}">

<div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Fishboxes Management</h1>
                            <p class="text-gray-600 mt-2">Manage your fish boxes and fish types inventory</p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                            <!-- Scan QR Button -->
                            <button id="scanQRBtn" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center space-x-2">
                                <x-heroicon-o-camera class="w-4 h-4" />
                                <span class="hidden sm:inline">Scan QR to Return</span>
                                <span class="sm:hidden">Scan QR</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-lg mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-8 px-4 md:px-6" aria-label="Tabs">
                            <a href="{{ route('broker.inventory.index') }}?tab=fishBoxes"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ ($currentTab ?? request('tab', 'fishBoxes')) === 'fishBoxes' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-archive-box class="w-5 h-5" />
                                    <span>Fish Boxes</span>
                                </div>
                            </a>
                            <a href="{{ route('broker.inventory.index') }}?tab=fishTypes"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ ($currentTab ?? request('tab')) === 'fishTypes' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-tag class="w-5 h-5" />
                                    <span>Fish Types</span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    @if(($currentTab ?? request('tab', 'fishBoxes')) === 'fishBoxes')
                        @include('broker.inventory.fish-boxes')
                    @elseif(($currentTab ?? request('tab')) === 'fishTypes')
                        @include('broker.inventory.fish-types', ['fishTypes' => $fishTypes ?? collect()])
                    @endif
                </div>
            </div>
<!-- Inventory page specific JS -->
<script src="{{ asset('js/inventory.js') }}" defer></script>
<script src="{{ asset('js/qr-code.js') }}" defer></script>

<!-- QR Scanner Scripts -->
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
