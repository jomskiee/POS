/**
 * First we will load all of this project's JavaScript dependencies which
 * includes libraries needed for the POS system functionality.
 */

require('./bootstrap');

// Third-party libraries via npm
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

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


});

