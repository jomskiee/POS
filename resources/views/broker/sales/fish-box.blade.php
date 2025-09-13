@extends('layouts.broker')

@section('content')
<div class="w-full">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $fishBox->status === 'In Stock' ? 'bg-green-100 text-green-800' : ($fishBox->status === 'Sold' ? 'bg-blue-100 text-blue-800' : ($fishBox->status === 'Returned' ? 'bg-yellow-100 text-yellow-800' : ($fishBox->status === 'Missing' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                    {{ $fishBox->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $fishBox->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button data-fish-box-id="{{ $fishBox->id }}"
                                            class="mark-as-missing-btn text-red-600 hover:text-red-900 transition-colors"
                                            title="Mark as Missing">
                                        <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                                    </button>
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

<!-- QR Code Modal -->
<div id="qrModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
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
<div id="qrScannerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Scan QR Code</h3>
                <button id="closeQrScannerModal" class="text-gray-400 hover:text-gray-600">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
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

<!-- Missing Confirmation Modal -->
<div id="missingConfirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Confirm Action</h3>
                <button id="closeMissingConfirmModal" class="text-gray-400 hover:text-gray-600">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Mark Fish Box as Missing</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Are you sure you want to mark this fish box as missing? This action cannot be undone.
                </p>
                <div class="flex justify-center space-x-3">
                    <button id="cancelMissingConfirm" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        No, Cancel
                    </button>
                    <button id="confirmMissing" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Yes, Mark as Missing
                    </button>
                </div>
            </div>
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

// Mark fish box as missing
let currentFishBoxId = null;

function markAsMissing(fishBoxId) {
    currentFishBoxId = fishBoxId;
    document.getElementById('missingConfirmModal').classList.remove('hidden');
}

function confirmMarkAsMissing() {
    if (currentFishBoxId) {
        // Create a form to submit the request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/broker/fish-boxes/${currentFishBoxId}/mark-missing`;

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

// Handle mark as missing button clicks
document.addEventListener('click', function(e) {
    if (e.target.closest('.mark-as-missing-btn')) {
        const fishBoxId = e.target.closest('.mark-as-missing-btn').getAttribute('data-fish-box-id');
        markAsMissing(fishBoxId);
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


// Missing Confirmation Modal Event Listeners
document.getElementById('closeMissingConfirmModal').addEventListener('click', function() {
    document.getElementById('missingConfirmModal').classList.add('hidden');
});

document.getElementById('cancelMissingConfirm').addEventListener('click', function() {
    document.getElementById('missingConfirmModal').classList.add('hidden');
});

document.getElementById('confirmMissing').addEventListener('click', function() {
    confirmMarkAsMissing();
});


// Close modals when clicking outside
document.getElementById('qrScannerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        stopQRScanner();
        this.classList.add('hidden');
    }
});
document.getElementById('missingConfirmModal').addEventListener('click', function(e) {
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


});
</script>

@endsection
