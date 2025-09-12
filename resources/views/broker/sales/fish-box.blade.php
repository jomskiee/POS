@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'Fish Boxes Management']
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
                            <h1 class="text-3xl font-bold text-gray-900">Fish Boxes Management</h1>
                            <p class="text-gray-600 mt-2">Track your fish boxes</p>
                        </div>
                        <div class="flex space-x-3">
                            <!-- Camera QR Scanner Button -->
                            <button id="scanQRBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Scan with Camera
                            </button>

                            <!-- Upload QR Image Button -->
                            <button id="uploadQRBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload QR Image
                            </button>

                            <!-- Manual QR Code Input -->
                            <button id="manualQRBtn" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Enter Manually
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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

<!-- QR Scanner Modal -->
<div id="qrScannerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Scan QR Code</h3>
                <button id="closeQrScannerModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="text-center">
                <div id="qr-reader" class="w-full max-w-md mx-auto"></div>
                <p id="qr-result" class="mt-4 text-sm text-gray-600"></p>
                <div class="mt-4">
                    <button id="startScanner" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium mr-2">
                        Start Scanner
                    </button>
                    <button id="stopScanner" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Stop Scanner
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload QR Image Modal -->
<div id="uploadQRModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Upload QR Code Image</h3>
                <button id="closeUploadQRModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="uploadQRForm" action="{{ route('broker.fish-boxes.update-status') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="qr_image" class="block text-sm font-medium text-gray-700 mb-2">QR Code Image</label>
                    <input type="file" name="qr_code" id="qr_image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Supported formats: JPG, PNG, GIF (Max: 2MB)</p>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelUploadQR" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Process Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Manual QR Input Modal -->
<div id="manualQRModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Enter QR Code</h3>
                <button id="closeManualQRModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="manualQRForm" action="{{ route('broker.fish-boxes.update-status') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="manual_qr_code" class="block text-sm font-medium text-gray-700 mb-2">QR Code</label>
                    <input type="text" name="qr_code" id="manual_qr_code"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter QR code manually" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelManualQR" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>

<script>
// QR Scanner functionality
let qrScanner = null;

// Copy QR code to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
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

// Open QR Scanner Modal
function openQRScanner() {
    document.getElementById('qrScannerModal').classList.remove('hidden');
    startQRScanner();
}

// Open Upload QR Image Modal
function openUploadQR() {
    document.getElementById('uploadQRModal').classList.remove('hidden');
}

// Open Manual QR Input Modal
function openManualQRInput() {
    document.getElementById('manualQRModal').classList.remove('hidden');
}

// Start QR Scanner
function startQRScanner() {
    if (qrScanner) {
        qrScanner.clear();
    }

    qrScanner = new Html5Qrcode("qr-reader");

    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 }
    };

    qrScanner.start(
        { facingMode: "environment" },
        config,
        onScanSuccess,
        onScanFailure
    ).catch(err => {
        console.error("Unable to start QR scanner", err);
        document.getElementById('qr-result').textContent = "Unable to start camera. Please check permissions.";
    });
}

// Stop QR Scanner
function stopQRScanner() {
    if (qrScanner) {
        qrScanner.stop().then(() => {
            qrScanner.clear();
            qrScanner = null;
        }).catch(err => {
            console.error("Error stopping scanner", err);
        });
    }
}

// Handle successful QR scan
function onScanSuccess(decodedText, decodedResult) {
    console.log(`QR Code detected: ${decodedText}`);
    document.getElementById('qr-result').textContent = `QR Code: ${decodedText}`;

    // Update fish box status
    updateFishBoxStatus(decodedText);

    // Stop scanner and close modal
    stopQRScanner();
    document.getElementById('qrScannerModal').classList.add('hidden');
}

// Handle QR scan failure
function onScanFailure(error) {
    // Most errors are handled silently to avoid spam
    // console.log("QR scan failed:", error);
}

// Update fish box status
function updateFishBoxStatus(qrCode) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("broker.fish-boxes.update-status") }}';

    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    // Add QR code
    const qrInput = document.createElement('input');
    qrInput.type = 'hidden';
    qrInput.name = 'qr_code';
    qrInput.value = qrCode;
    form.appendChild(qrInput);

    document.body.appendChild(form);
    form.submit();
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

// QR Scanner Modal Event Listeners
document.getElementById('closeQrScannerModal').addEventListener('click', function() {
    stopQRScanner();
    document.getElementById('qrScannerModal').classList.add('hidden');
});

document.getElementById('startScanner').addEventListener('click', function() {
    startQRScanner();
});

document.getElementById('stopScanner').addEventListener('click', function() {
    stopQRScanner();
});

// Upload QR Modal Event Listeners
document.getElementById('closeUploadQRModal').addEventListener('click', function() {
    document.getElementById('uploadQRModal').classList.add('hidden');
});

document.getElementById('cancelUploadQR').addEventListener('click', function() {
    document.getElementById('uploadQRModal').classList.add('hidden');
});

// Manual QR Modal Event Listeners
document.getElementById('closeManualQRModal').addEventListener('click', function() {
    document.getElementById('manualQRModal').classList.add('hidden');
});

document.getElementById('cancelManualQR').addEventListener('click', function() {
    document.getElementById('manualQRModal').classList.add('hidden');
});

// Close modals when clicking outside
document.getElementById('qrScannerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        stopQRScanner();
        this.classList.add('hidden');
    }
});

document.getElementById('uploadQRModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

document.getElementById('manualQRModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

// Add event listeners for the main buttons
document.addEventListener('DOMContentLoaded', function() {
    // QR Scanner Button
    const scanQRBtn = document.getElementById('scanQRBtn');
    if (scanQRBtn) {
        scanQRBtn.addEventListener('click', function() {
            openQRScanner();
        });
    }

    // Upload QR Image Button
    const uploadQRBtn = document.getElementById('uploadQRBtn');
    if (uploadQRBtn) {
        uploadQRBtn.addEventListener('click', function() {
            openUploadQR();
        });
    }

    // Manual QR Input Button
    const manualQRBtn = document.getElementById('manualQRBtn');
    if (manualQRBtn) {
        manualQRBtn.addEventListener('click', function() {
            openManualQRInput();
        });
    }
});
</script>
