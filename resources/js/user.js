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

            switch (action) {
                case 'deactivate':
                    title = 'Deactivate user?';
                    text = 'This will deactivate the user account.';
                    confirmText = 'Yes, deactivate';
                    break;
                case 'activate':
                    title = 'Activate user?';
                    text = 'This will activate the user account.';
                    confirmText = 'Yes, activate';
                    break;
                case 'delete':
                    title = 'Delete user?';
                    text = 'This action cannot be undone.';
                    confirmText = 'Yes, delete';
                    break;
            }

            Swal.fire({
                title,
                text,
                icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2563eb',
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
