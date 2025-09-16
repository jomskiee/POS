/**
 * QR Backend Handler
 * Handles backend communication specifically for QR scanner functionality
 * Focuses on QR code processing and fish box status updates via scanning
 */

class QRBackendHandler {
    constructor() {
        this.baseUrl = null;
        this.csrfToken = null;
        this.isProcessing = false;
    }

    /**
     * Initialize the backend handler with required tokens and URLs
     */
    initialize() {
        this.baseUrl = this.getBaseUrl();
        this.csrfToken = this.getCSRFToken();

        if (!this.csrfToken) {
            console.error('CSRF token not found');
            return false;
        }

        return true;
    }

    /**
     * Get base URL from meta tag
     */
    getBaseUrl() {
        const meta = document.querySelector('meta[name="fish-box-update-url"]');
        return meta ? meta.getAttribute('content') : null;
    }

    /**
     * Get CSRF token from meta tag
     */
    getCSRFToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : null;
    }

    /**
     * Update fish box status via AJAX
     * @param {string} qrCode - QR code value
     * @returns {Promise<Object>} - Response object with success/error status
     */
    async updateFishBoxStatus(qrCode) {
        if (this.isProcessing) {
            console.log('Already processing a request, ignoring...');
            return { success: false, message: 'Request already in progress' };
        }

        if (!this.baseUrl || !this.csrfToken) {
            console.error('Backend handler not properly initialized');
            return {
                success: false,
                message: 'Configuration error. Please refresh the page.'
            };
        }

        this.isProcessing = true;

        try {
            const formData = new FormData();
            formData.append('qr_code', qrCode);
            formData.append('_token', this.csrfToken);

            const response = await fetch(this.baseUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                return {
                    success: true,
                    message: result.message || 'Fish box status updated successfully!',
                    data: result.data || null
                };
            } else {
                return {
                    success: false,
                    message: result.message || 'Failed to update fish box status',
                    errors: result.errors || null
                };
            }

        } catch (error) {
            console.error('Network error updating fish box status:', error);
            return {
                success: false,
                message: 'Network error. Please check your connection and try again.'
            };
        } finally {
            this.isProcessing = false;
        }
    }


    /**
     * Get fish box details by QR code
     * @param {string} qrCode - QR code value
     * @returns {Promise<Object>} - Fish box details
     */
    async getFishBoxByQRCode(qrCode) {
        try {
            const response = await fetch(`/api/fish-boxes/qr/${encodeURIComponent(qrCode)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                return await response.json();
            } else {
                return null;
            }
        } catch (error) {
            console.error('Error fetching fish box details:', error);
            return null;
        }
    }

    /**
     * Validate QR code format
     * @param {string} qrCode - QR code to validate
     * @returns {boolean} - Whether QR code format is valid
     */
    validateQRCode(qrCode) {
        if (!qrCode || typeof qrCode !== 'string') {
            return false;
        }

        // Check if it looks like a UUID (common QR code format)
        const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;

        // Also allow other formats (alphanumeric, etc.)
        const alphanumericRegex = /^[a-zA-Z0-9\-_]+$/;

        return uuidRegex.test(qrCode) || alphanumericRegex.test(qrCode);
    }

    /**
     * Show success notification
     * @param {string} message - Success message
     */
    showSuccess(message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#059669'
            });
        } else if (typeof window.Swal !== 'undefined') {
            window.Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#059669'
            });
        } else if (typeof toastr !== 'undefined') {
            toastr.success(message);
        } else {
            alert(message);
        }
    }

    /**
     * Show error notification
     * @param {string} message - Error message
     */
    showError(message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626'
            });
        } else if (typeof window.Swal !== 'undefined') {
            window.Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626'
            });
        } else if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert(message);
        }
    }

    /**
     * Show warning notification
     * @param {string} message - Warning message
     */
    showWarning(message) {
        if (typeof toastr !== 'undefined') {
            toastr.warning(message);
        } else {
            alert(message);
        }
    }

    /**
     * Show info notification
     * @param {string} message - Info message
     */
    showInfo(message) {
        if (typeof toastr !== 'undefined') {
            toastr.info(message);
        } else {
            alert(message);
        }
    }

    /**
     * Handle successful QR scan result
     * @param {string} qrCode - Scanned QR code
     * @param {Function} onSuccess - Success callback
     * @param {Function} onError - Error callback
     */
    async handleQRScanResult(qrCode, onSuccess = null, onError = null) {
        // Validate QR code format
        if (!this.validateQRCode(qrCode)) {
            const errorMsg = 'Invalid QR code format. Please scan a valid QR code.';
            this.showError(errorMsg);
            if (onError) onError(errorMsg);
            return;
        }

        // Show processing notification with SweetAlert
        this.showProcessingDialog();

        try {
            // Update fish box status
            const result = await this.updateFishBoxStatus(qrCode);

            // Close processing dialog
            this.closeProcessingDialog();

            if (result.success) {
                this.showSuccess(result.message);
                if (onSuccess) onSuccess(result);
            } else {
                this.showError(result.message);
                if (onError) onError(result.message);
            }

        } catch (error) {
            // Close processing dialog
            this.closeProcessingDialog();

            const errorMsg = 'Network error. Please check your connection and try again.';
            this.showError(errorMsg);
            if (onError) onError(errorMsg);
        }
    }

    /**
     * Show processing dialog with SweetAlert
     */
    showProcessingDialog() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Processing QR Code',
                text: 'Please wait while we process your QR code...',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        } else {
            this.showInfo('Processing QR code...');
        }
    }

    /**
     * Close processing dialog
     */
    closeProcessingDialog() {
        if (typeof Swal !== 'undefined') {
            Swal.close();
        }
    }

}

// Make the class available globally
window.QRBackendHandler = QRBackendHandler;
