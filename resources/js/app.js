/**
 * First we will load all of this project's JavaScript dependencies which
 * includes libraries needed for the POS system functionality.
 */

require('./bootstrap');

// Third-party libraries via npm
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';

// Make SweetAlert and Toastr available globally
window.Swal = Swal;
window.toastr = toastr;



/**
 * POS System JavaScript
 * Using Alpine.js for reactive components and vanilla JS for custom functionality
 */

document.addEventListener('DOMContentLoaded', () => {
    // Configure Toastr
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3500
    };

    // Show flash messages from meta tags
    const getMeta = (name) => {
        const el = document.querySelector(`meta[name="${name}"]`);
        return el && el.getAttribute('content') ? el.getAttribute('content') : '';
    };

    const flashSuccess = getMeta('flash-success');
    const flashError = getMeta('flash-error');
    const flashWarning = getMeta('flash-warning');
    const flashInfo = getMeta('flash-info');

    if (flashSuccess) toastr.success(flashSuccess);
    if (flashError) toastr.error(flashError);
    if (flashWarning) toastr.warning(flashWarning);
    if (flashInfo) toastr.info(flashInfo);

    // Initialize SweetAlert form handlers
    initializeSweetAlert();

});


/**
 * Initialize SweetAlert form handlers
 */
function initializeSweetAlert() {
    const confirmableForms = document.querySelectorAll('form[data-swal]');

    confirmableForms.forEach(function (form) {
        const handleSubmit = function (e) {
            e.preventDefault();

            const action = form.getAttribute('data-swal');
            const recordName = form.getAttribute('data-record-name') || '';

            let title = 'Are you sure?';
            let text = '';
            let confirmText = 'Yes';
            let icon = 'warning';

            // Get the record type from the form action URL
            const recordType = getRecordTypeFromForm(form);

            switch (action) {
                case 'delete':
                    title = `Delete ${recordType}?`;
                    text = `This will permanently delete the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''} and cannot be undone.`;
                    confirmText = `Yes, delete ${recordType.toLowerCase()}`;
                    break;
                case 'deactivate':
                    title = `Deactivate ${recordType}?`;
                    text = `This will deactivate the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''}.`;
                    confirmText = `Yes, deactivate`;
                    break;
                case 'activate':
                    title = `Activate ${recordType}?`;
                    text = `This will activate the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''}.`;
                    confirmText = `Yes, activate`;
                    break;
                case 'mark-missing':
                    title = `Mark Fish Box as Missing?`;
                    text = `Are you sure you want to mark this fish box${recordName ? ` "${recordName}"` : ''} as missing? This action cannot be undone.`;
                    confirmText = `Yes, Mark as Missing`;
                    icon = 'warning';
                    break;
                case 'return-to-stock':
                    title = `Return Fish Boxes to In Stock?`;
                    text = `This will change all "Returned" fish boxes back to "In Stock" status. Are you sure?`;
                    confirmText = `Yes, Return to Stock`;
                    icon = 'question';
                    break;
                default:
                    title = 'Are you sure?';
                    text = 'This action cannot be undone.';
                    confirmText = 'Yes, continue';
            }
            Swal.close();
            // Use setTimeout to ensure proper initialization
            setTimeout(() => {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: (action === 'delete' || action === 'mark-missing') ? '#dc2626' : '#059669',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Remove the event listener to prevent infinite loop
                        form.removeEventListener('submit', handleSubmit);
                        // Submit the form
                        form.submit();
                    }
                });
            }, 10);
        };

        form.addEventListener('submit', handleSubmit);
    });
}

/**
 * Get record type from form action URL
 */
function getRecordTypeFromForm(form) {
    const action = form.getAttribute('action') || '';

    if (action.includes('sales') && action.includes('payments')) return 'Sale Payment';
    if (action.includes('sales')) return 'Sale';
    if (action.includes('fish-boxes') || action.includes('fish-box')) return 'Fish Box';
    if (action.includes('fish-type')) return 'Fish Type';
    if (action.includes('users')) return 'User';
    if (action.includes('brokers')) return 'Broker';
    if (action.includes('admins')) return 'Admin';

    return 'Record';
}

