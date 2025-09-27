import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {
    const confirmableForms = document.querySelectorAll('form[data-swal]');
    confirmableForms.forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const action = form.getAttribute('data-swal');
            let title = 'Are you sure?';
            let text = '';
            let confirmText = 'Yes';
            const icon = 'warning';

            // Get the record type from the form action URL
            const recordType = getRecordTypeFromForm(form);
            const recordName = getRecordNameFromForm(form);

            switch (action) {
                case 'delete':
                    title = `Delete ${recordType}?`;
                    text = `This will permanently delete the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''} and cannot be undone.`;
                    confirmText = `Yes, delete ${recordType.toLowerCase()}`;
                    break;
                case 'deactivate':
                    title = `Deactivate ${recordType}?`;
                    text = `This will deactivate the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''}.`;
                    confirmText = `Yes, deactivate ${recordType.toLowerCase()}`;
                    break;
                case 'activate':
                    title = `Activate ${recordType}?`;
                    text = `This will activate the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''}.`;
                    confirmText = `Yes, activate ${recordType.toLowerCase()}`;
                    break;
                case 'mark-missing':
                    title = `Mark ${recordType} as Missing?`;
                    text = `This will mark the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''} as missing.`;
                    confirmText = `Yes, mark as missing`;
                    break;
                case 'return-fish-box':
                    title = `Return ${recordType}?`;
                    text = `This will mark the ${recordType.toLowerCase()}${recordName ? ` "${recordName}"` : ''} as returned.`;
                    confirmText = `Yes, return ${recordType.toLowerCase()}`;
                    break;
            }

            Swal.fire({
                title,
                text,
                icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc2626', // Red color for delete actions
                cancelButtonColor: '#6b7280',
                focusCancel: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

/**
 * Determine the record type from the form action URL
 * @param {HTMLFormElement} form
 * @returns {string}
 */
function getRecordTypeFromForm(form) {
    const action = form.action;

    if (action.includes('fish-types')) {
        return 'Fish Type';
    } else if (action.includes('fish-boxes')) {
        return 'Fish Box';
    } else if (action.includes('inventory')) {
        return 'Inventory Item';
    } else {
        return 'Item';
    }
}

/**
 * Extract the record name from the form or surrounding elements
 * @param {HTMLFormElement} form
 * @returns {string|null}
 */
function getRecordNameFromForm(form) {
    // Try to find the record name from various sources

    // Method 1: Look for data attribute on the form
    const dataName = form.getAttribute('data-record-name');
    if (dataName) {
        return dataName;
    }

    // Method 2: Look for the record name in the same table row
    const tableRow = form.closest('tr');
    if (tableRow) {
        // Look for the first cell that contains the name (usually the first column)
        const nameCell = tableRow.querySelector('td:first-child .text-sm.font-medium, td:first-child .font-medium');
        if (nameCell) {
            return nameCell.textContent.trim();
        }
    }

    // Method 3: Look for hidden input with name
    const nameInput = form.querySelector('input[name="name"], input[name="record_name"]');
    if (nameInput) {
        return nameInput.value;
    }

    return null;
}
