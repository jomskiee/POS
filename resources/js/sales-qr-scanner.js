/**
 * Sales QR Scanner
 * Handles QR code scanning for adding fish boxes to sales details
 */

import QrScanner from 'qr-scanner';

class SalesQRScanner {
    constructor() {
        this.scanner = null;
        this.isProcessing = false;
        this.modal = null;
        this.isModalCreated = false;
        this.onScanSuccess = null;
    }

    /**
     * Set the callback function for successful scans
     * @param {Function} callback - Function to call when QR code is successfully scanned
     */
    setScanSuccessCallback(callback) {
        this.onScanSuccess = callback;
    }

    /**
     * Open the QR Scanner modal
     */
    openModal() {
        // First check if we can access camera
        this.checkCameraPermission().then(() => {
            this.createModal();
            if (this.modal) {
                this.modal.classList.remove('hidden');
            }
        }).catch((error) => {
            console.error('Camera permission check failed:', error);
            this.showCameraPermissionError(error);
        });
    }

    /**
     * Check camera permission before opening modal
     */
    async checkCameraPermission() {
        try {
            // Check if getUserMedia is supported
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('getUserMedia is not supported');
            }

            // First, try to stop any existing streams
            await this.stopExistingCameraStreams();

            // Try to get camera access with a timeout
            const stream = await Promise.race([
                navigator.mediaDevices.getUserMedia({ video: true }),
                new Promise((_, reject) =>
                    setTimeout(() => reject(new Error('Camera access timeout')), 5000)
                )
            ]);

            // Immediately stop the test stream
            stream.getTracks().forEach(track => track.stop());

            return true;
        } catch (error) {
            // If it's a "NotReadableError", the camera is already in use
            if (error.name === 'NotReadableError') {
                throw new Error('Camera is already in use by another application. Please close other apps using the camera and try again.');
            }

            throw error;
        }
    }

    /**
     * Show camera permission error
     */
    showCameraPermissionError(error = null) {
        let title = 'Camera Access Required';
        let text = 'Please allow camera access to use the QR scanner. You can enable it in your browser settings.';

        if (error && error.message.includes('already in use')) {
            title = 'Camera Already in Use';
            text = 'The camera is currently being used by another application or browser tab. Please close other apps using the camera and try again.';
        }

        if (window.Swal) {
            window.Swal.fire({
                icon: 'error',
                title: title,
                text: text,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626'
            });
        } else {
            alert(text);
        }
    }

    /**
     * Close the QR Scanner modal
     */
    closeModal() {
        this.stopScanner();
        if (this.modal) {
            this.modal.classList.add('hidden');
            // Remove modal from DOM
            setTimeout(() => {
                if (this.modal && this.modal.parentNode) {
                    this.modal.parentNode.removeChild(this.modal);
                    this.modal = null;
                    this.isModalCreated = false;
                }
            }, 300);
        }
    }

    /**
     * Create the QR Scanner modal with modern design
     */
    createModal() {
        if (this.isModalCreated) return;

        const modalHTML = `
            <div id="salesQrScannerModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Backdrop with blur effect -->
                    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal panel -->
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-white">Scan Fish Box QR Code</h3>
                                <button onclick="window.salesQrScanner.closeModal()" class="text-white hover:text-gray-200 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="bg-white px-6 py-4">
                            <!-- Camera container -->
                            <div class="relative bg-gray-100 rounded-lg overflow-hidden mb-4" style="height: 300px;">
                                <video id="salesQrVideo" class="w-full h-full object-cover" autoplay muted playsinline></video>
                                <!-- Scanning overlay -->
                                <div class="absolute inset-0 pointer-events-none">
                                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                                    <!-- Scanning frame -->
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 border-2 border-white rounded-lg">
                                        <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-blue-500 rounded-tl-lg"></div>
                                        <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-blue-500 rounded-tr-lg"></div>
                                        <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-blue-500 rounded-bl-lg"></div>
                                        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-blue-500 rounded-br-lg"></div>
                                    </div>
                                    <!-- Scanning line animation -->
                                    <div id="salesQrScanLine" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-0.5 bg-blue-500 opacity-0"></div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div id="salesQrStatus" class="text-center">
                                <div class="flex items-center justify-center space-x-2 mb-2">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                    <p class="text-gray-600 font-medium">Initializing camera...</p>
                                </div>
                                <p class="text-gray-500 text-sm">Point your camera at a fish box QR code</p>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
                            <button onclick="window.salesQrScanner.closeModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = document.getElementById('salesQrScannerModal');
        this.isModalCreated = true;

        // Start scanner when modal is opened
        setTimeout(() => {
            this.startScanner();
        }, 100);
    }

    /**
     * Start the QR scanner
     */
    async startScanner() {
        try {
            const videoElement = document.getElementById('salesQrVideo');
            const statusElement = document.getElementById('salesQrStatus');

            if (!videoElement) {
                return;
            }

            // First, stop any existing camera streams
            await this.stopExistingCameraStreams();

            // Check camera permission with fallback options
            let stream;
            try {
                // Try back camera first
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                });
            } catch (backCameraError) {
                try {
                    // Fallback to front camera
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'user'
                        }
                    });
                } catch (frontCameraError) {
                    // Fallback to any available camera
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                }
            }

            videoElement.srcObject = stream;

            // Start the scanner
            this.scanner = new QrScanner(videoElement, (result) => {
                this.handleScanResult(result.data);
            }, {
                highlightScanRegion: true,
                highlightCodeOutline: true,
            });

            await this.scanner.start();

            // Start scanning line animation
            this.startScanningAnimation();

            // Update status
            if (statusElement) {
                statusElement.innerHTML = `
                    <div class="text-center">
                        <div class="flex items-center justify-center space-x-2 mb-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <p class="text-green-600 font-medium">Camera active</p>
                        </div>
                        <p class="text-gray-600 text-sm">Point your camera at a fish box QR code</p>
                    </div>
                `;
            }

        } catch (error) {
            console.error('Error starting scanner:', error);
            this.handleCameraError(error);
        }
    }

    /**
     * Stop any existing camera streams to prevent conflicts
     */
    async stopExistingCameraStreams() {
        try {
            // Stop any existing streams from other QR scanners
            if (window.qrScanner && window.qrScanner.scanner) {
                window.qrScanner.stopScanner();
                // Also close the modal if it's open
                if (window.qrScanner.modal) {
                    window.qrScanner.closeModal();
                }
            }

            // Stop any streams from video elements
            const allVideos = document.querySelectorAll('video');

            allVideos.forEach((video) => {
                if (video.srcObject) {
                    const tracks = video.srcObject.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;
                }
            });

            // Force stop any active media streams by getting a temporary stream and stopping it
            try {
                const tempStream = await navigator.mediaDevices.getUserMedia({ video: true });
                tempStream.getTracks().forEach(track => track.stop());
            } catch (tempError) {
                // No active streams to force stop
            }

            // Longer delay to ensure streams are properly stopped
            await new Promise(resolve => setTimeout(resolve, 2000));
        } catch (error) {
            // Error stopping existing streams
        }
    }

    /**
     * Handle camera errors with specific error messages
     */
    handleCameraError(error) {
        const statusElement = document.getElementById('salesQrStatus');
        let errorMessage = 'Unable to access camera. Please check permissions.';

        if (error.name === 'NotAllowedError') {
            errorMessage = 'Camera permission denied. Please allow camera access and try again.';
        } else if (error.name === 'NotFoundError') {
            errorMessage = 'No camera found on this device.';
        } else if (error.name === 'NotReadableError') {
            errorMessage = 'Camera is already in use by another application. Please close other apps using the camera.';
        } else if (error.name === 'OverconstrainedError') {
            errorMessage = 'Camera constraints cannot be satisfied.';
        } else if (error.name === 'SecurityError') {
            errorMessage = 'Camera access blocked due to security restrictions.';
        }

        if (statusElement) {
            statusElement.innerHTML = `
                <div class="text-center">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        <p class="text-red-600 font-medium">Camera Error</p>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">${errorMessage}</p>
                    <div class="space-x-2">
                        <button onclick="window.salesQrScanner.requestCameraPermission()" class="px-4 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                            Try Again
                        </button>
                        <button onclick="window.salesQrScanner.closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">
                            Cancel
                        </button>
                    </div>
                </div>
            `;
        }
    }

    /**
     * Start scanning line animation
     */
    startScanningAnimation() {
        const scanLine = document.getElementById('salesQrScanLine');
        if (scanLine) {
            scanLine.style.opacity = '1';
            scanLine.style.animation = 'scanLine 2s ease-in-out infinite';
        }
    }

    /**
     * Stop the QR scanner
     */
    stopScanner() {
        if (this.scanner) {
            this.scanner.stop();
            this.scanner.destroy();
            this.scanner = null;
        }

        // Stop video stream
        const videoElement = document.getElementById('salesQrVideo');
        if (videoElement && videoElement.srcObject) {
            const tracks = videoElement.srcObject.getTracks();
            tracks.forEach(track => track.stop());
            videoElement.srcObject = null;
        }

        // Stop scanning animation
        const scanLine = document.getElementById('salesQrScanLine');
        if (scanLine) {
            scanLine.style.animation = 'none';
            scanLine.style.opacity = '0';
        }
    }

    /**
     * Handle scan result
     */
    async handleScanResult(qrCode) {
        // Prevent multiple processing
        if (this.isProcessing) {
            return;
        }

        this.isProcessing = true;

        // Stop scanner immediately
        this.stopScanner();

        // Show processing message
        const statusElement = document.getElementById('salesQrStatus');
        if (statusElement) {
            statusElement.innerHTML = `
                <div class="text-center">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                        <p class="text-blue-600 font-medium">Processing QR Code...</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-2">
                        <p class="text-xs text-blue-700 font-mono">${qrCode}</p>
                    </div>
                </div>
            `;
        }

        try {
            // Get fish box details by QR code
            const fishBox = await this.getFishBoxByQRCode(qrCode);

            if (fishBox) {
                // Handle the successful scan
                this.handleSalesQRScanSuccess(fishBox);
                this.closeModal();
            } else {
                this.showError('Fish box not found or not available for sale');
            }
        } catch (error) {
            this.showError('Error processing QR code. Please try again.');
        } finally {
            this.isProcessing = false;
        }
    }

    /**
     * Get fish box details by QR code
     * @param {string} qrCode - QR code value
     * @returns {Promise<Object|null>} - Fish box details or null
     */
    async getFishBoxByQRCode(qrCode) {
        try {
            const response = await fetch(`/broker/sales/fish-boxes/${encodeURIComponent(qrCode)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                return data;
            } else {
                return null;
            }
        } catch (error) {
            return null;
        }
    }

    /**
     * Show error message
     * @param {string} message - Error message
     */
    showError(message) {
        const statusElement = document.getElementById('salesQrStatus');
        if (statusElement) {
            statusElement.innerHTML = `
                <div class="text-center">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        <p class="text-red-600 font-medium">Error</p>
                    </div>
                    <p class="text-gray-600 text-sm">${message}</p>
                    <button onclick="window.salesQrScanner.startScanner()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded text-sm mr-2">
                        Try Again
                    </button>
                    <button onclick="window.salesQrScanner.closeModal()" class="mt-2 px-4 py-2 bg-gray-500 text-white rounded text-sm">
                        Cancel
                    </button>
                </div>
            `;
        }
    }

    /**
     * Request camera permission
     */
    async requestCameraPermission() {
        try {
            // Stop existing streams first
            await this.stopExistingCameraStreams();

            // Try to get camera access
            await navigator.mediaDevices.getUserMedia({ video: true });
            this.startScanner();
        } catch (error) {
            console.error('Camera permission denied:', error);
            this.handleCameraError(error);
        }
    }

    /**
     * Handle successful QR scan for sales
     * @param {Object} fishBox - Fish box data from QR scan
     */
    handleSalesQRScanSuccess(fishBox) {
        // Extract the actual fish box data from the response
        const fishBoxData = fishBox.data || fishBox;

        // Add the fish box to sales details
        this.addFishBoxToSalesDetails(fishBoxData);

        // Get fish type name
        const fishTypeName = fishBoxData.fish_type?.name || fishBoxData.fish_type_name || fishBoxData.fish_type || 'Unknown';
        const boxName = fishBoxData.name || `Fish Box #${fishBoxData.id}`;

        // Show success message
        if (window.toastr) {
            window.toastr.success(`${boxName} (${fishTypeName}) added! Fish type auto-selected, quantity set to 1.`);
        }
    }

    /**
     * Add fish box to sales details
     * @param {Object} fishBox - Fish box data
     */
    addFishBoxToSalesDetails(fishBox) {
        const container = document.getElementById('sales-details-container');
        if (!container) {
            return;
        }

        // Get the fish type ID and name from fish box data
        const fishTypeId = fishBox.fish_type_id || (fishBox.fish_type ? fishBox.fish_type.id : null);
        const fishTypeName = fishBox.fish_type?.name || fishBox.fish_type_name || fishBox.fish_type || '';

        console.log('Fish Box Data:', fishBox);
        console.log('Fish Type ID:', fishTypeId);
        console.log('Fish Type Name:', fishTypeName);

        // Check for existing blank rows (no fish type selected)
        const existingRows = container.querySelectorAll('.sales-detail-row');
        let targetRow = null;
        let rowIndex = null;

        for (let i = 0; i < existingRows.length; i++) {
            const row = existingRows[i];
            const fishTypeSelect = row.querySelector('.fish-type-select');

            // Check if row is empty (no fish type selected)
            if (fishTypeSelect && !fishTypeSelect.value) {
                targetRow = row;
                rowIndex = row.dataset.index;
                break;
            }
        }

        // If no blank row found, create a new one
        if (!targetRow) {
            const template = document.getElementById('sales-detail-row-template');
            if (!template) {
                console.error('Sales detail row template not found');
                return;
            }

            rowIndex = existingRows.length;
            const newRow = template.content.cloneNode(true).querySelector('.sales-detail-row');
            newRow.dataset.index = rowIndex;

            // Update all input names to use the correct index
            newRow.querySelectorAll('input, select').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace('[INDEX]', `[${rowIndex}]`);
                }
            });

            container.appendChild(newRow);
            targetRow = container.querySelector(`.sales-detail-row[data-index="${rowIndex}"]`);
        }

        if (!targetRow) {
            console.error('Could not find or create target row');
            return;
        }

        // Mark as scanned
        targetRow.dataset.scanned = 'true';

        // Set fish type and disable it
        const fishTypeSelect = targetRow.querySelector('.fish-type-select');
        console.log('Fish Type Select Element:', fishTypeSelect);
        console.log('Setting fish type to:', fishTypeId);

        if (fishTypeSelect && fishTypeId) {
            fishTypeSelect.value = fishTypeId;
            console.log('Fish Type Select Value After Setting:', fishTypeSelect.value);

            // Add hidden input to preserve fish_type_id when select is disabled
            // (disabled inputs are not submitted with the form)
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = fishTypeSelect.name;
            hiddenInput.value = fishTypeId;
            hiddenInput.className = 'fish-type-hidden-input';
            fishTypeSelect.parentNode.appendChild(hiddenInput);

            fishTypeSelect.disabled = true;
            fishTypeSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
        } else {
            console.warn('Could not set fish type - Select:', !!fishTypeSelect, 'ID:', !!fishTypeId);
        }

        // Set quantity to 1 and disable it
        const quantityInput = targetRow.querySelector('.quantity-input');
        if (quantityInput) {
            quantityInput.value = 1;

            // Add hidden input to preserve quantity when input is disabled
            const hiddenQtyInput = document.createElement('input');
            hiddenQtyInput.type = 'hidden';
            hiddenQtyInput.name = quantityInput.name;
            hiddenQtyInput.value = 1;
            hiddenQtyInput.className = 'quantity-hidden-input';
            quantityInput.parentNode.appendChild(hiddenQtyInput);

            quantityInput.disabled = true;
            quantityInput.classList.add('bg-gray-100', 'cursor-not-allowed');
        }

        // Set item name
        const itemInput = targetRow.querySelector('.item-input');
        if (itemInput) {
            itemInput.value = fishTypeName;
        }

        // Create fish box display (no dropdown, just showing the scanned box)
        const fishBoxesContainer = targetRow.querySelector('.fish-boxes-container');
        if (fishBoxesContainer) {
            fishBoxesContainer.innerHTML = `
                <div class="fish-box-item mb-2">
                    <div class="w-full px-3 py-2 border border-green-300 bg-green-50 rounded-lg text-sm">
                        <div class="flex items-center text-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">${fishBox.name || `Fish Box #${fishBox.id}`}</span>
                            <span class="ml-2 text-xs">(Scanned)</span>
                        </div>
                    </div>
                    <input type="hidden" name="sales_details[${rowIndex}][box_id][]" value="${fishBox.id}">
                </div>
            `;
        }
    }
}

// Make the class available globally
window.SalesQRScanner = SalesQRScanner;
