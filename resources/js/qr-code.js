import QRCodeStyling from 'qr-code-styling';

// QR Code Modal functionality
window.QRCodeModal = {
    init() {
        this.bindEvents();
    },

    bindEvents() {
        // Listen for QR code button clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.qr-code-btn')) {
                e.preventDefault();
                const button = e.target.closest('.qr-code-btn');
                const qrData = button.dataset.qrData;
                const fishBoxName = button.dataset.fishBoxName;
                this.showQRModal(qrData, fishBoxName);
            }
        });

        // Close modal when clicking outside or on close button
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('qr-modal-overlay') || e.target.closest('.qr-modal-close')) {
                this.hideQRModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.hideQRModal();
            }
        });
    },

    showQRModal(qrData, fishBoxName) {
        // Create modal HTML
        const modalHTML = `
            <div id="qr-modal" class="fixed inset-0 z-50 overflow-y-auto qr-modal-overlay" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                        <!-- Modal Header -->
                        <div class="bg-white px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                                    QR Code - ${fishBoxName}
                                </h3>
                                <button class="qr-modal-close text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div class="bg-white px-6 py-6">
                            <div class="flex flex-col items-center">
                                <div id="qr-code-container" class="mb-4"></div>
                                <p class="text-sm text-gray-600 text-center mb-4">
                                    Scan this QR code to view fish box details
                                </p>
                                <div class="flex space-x-3">
                                    <button id="download-png" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                        Download PNG
                                    </button>
                                    <button id="download-svg" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                        Download SVG
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to DOM
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Generate QR Code
        this.generateQRCode(qrData);
    },

    generateQRCode(data) {
        const qrCode = new QRCodeStyling({
            width: 256,
            height: 256,
            type: "svg",
            data: data,
            dotsOptions: {
                color: "#2563eb", // Blue color to match theme
                type: "rounded"
            },
            backgroundOptions: {
                color: "#ffffff",
            },
            cornersSquareOptions: {
                color: "#1d4ed8",
                type: "extra-rounded"
            },
            cornersDotOptions: {
                color: "#1e40af",
                type: "dot"
            },
            qrOptions: {
                errorCorrectionLevel: 'M'
            }
        });

        // Append QR code to container
        const container = document.getElementById('qr-code-container');
        qrCode.append(container);

        // Bind download buttons
        document.getElementById('download-png').addEventListener('click', () => {
            qrCode.download({ name: `qr-code-${Date.now()}`, extension: 'png' });
        });

        document.getElementById('download-svg').addEventListener('click', () => {
            qrCode.download({ name: `qr-code-${Date.now()}`, extension: 'svg' });
        });

        // Store qrCode instance for potential future use
        this.currentQRCode = qrCode;
    },

    hideQRModal() {
        const modal = document.getElementById('qr-modal');
        if (modal) {
            modal.remove();
        }
        this.currentQRCode = null;
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.QRCodeModal.init();
});
