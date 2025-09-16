// Print Receipt functionality
class PrintReceipt {
    static print(receiptElementId, receiptTitle = 'Receipt') {
        const receiptContent = document.getElementById(receiptElementId);

        if (!receiptContent) {
            console.error('Receipt content not found');
            return;
        }

        // Create a new window for printing
        const printWindow = window.open('', '_blank', 'width=800,height=600');

        if (!printWindow) {
            alert('Please allow popups to print the receipt');
            return;
        }

        // Get the receipt HTML
        const receiptHTML = receiptContent.innerHTML;

        // Create the complete HTML document for printing
        const printHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>${receiptTitle}</title>
                <style>
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                        margin: 0;
                        padding: 20px;
                        background: white;
                        color: #333;
                    }
                    .max-w-md {
                        max-width: none;
                        width: 100%;
                    }
                    .text-center {
                        text-align: center;
                    }
                    .border-b {
                        border-bottom: 1px solid #e5e7eb;
                    }
                    .border-t {
                        border-top: 1px solid #e5e7eb;
                    }
                    .border-gray-200 {
                        border-color: #e5e7eb;
                    }
                    .pb-4 {
                        padding-bottom: 1rem;
                    }
                    .pt-4 {
                        padding-top: 1rem;
                    }
                    .mb-4 {
                        margin-bottom: 1rem;
                    }
                    .mb-2 {
                        margin-bottom: 0.5rem;
                    }
                    .mb-3 {
                        margin-bottom: 0.75rem;
                    }
                    .text-2xl {
                        font-size: 1.5rem;
                    }
                    .text-sm {
                        font-size: 0.875rem;
                    }
                    .text-xs {
                        font-size: 0.75rem;
                    }
                    .font-bold {
                        font-weight: 700;
                    }
                    .font-semibold {
                        font-weight: 600;
                    }
                    .font-medium {
                        font-weight: 500;
                    }
                    .text-gray-900 {
                        color: #111827;
                    }
                    .text-gray-600 {
                        color: #4b5563;
                    }
                    .text-gray-500 {
                        color: #6b7280;
                    }
                    .text-green-600 {
                        color: #059669;
                    }
                    .text-orange-600 {
                        color: #ea580c;
                    }
                    .flex {
                        display: flex;
                    }
                    .justify-between {
                        justify-content: space-between;
                    }
                    .items-start {
                        align-items: flex-start;
                    }
                    .space-y-2 > * + * {
                        margin-top: 0.5rem;
                    }
                    .space-y-3 > * + * {
                        margin-top: 0.75rem;
                    }
                    .flex-1 {
                        flex: 1 1 0%;
                    }
                    @media print {
                        body {
                            margin: 0;
                            padding: 0;
                        }
                        @page {
                            margin: 0.5in;
                            size: A4;
                        }
                    }
                </style>
            </head>
            <body>
                ${receiptHTML}
            </body>
            </html>
        `;

        // Write the HTML to the print window
        printWindow.document.write(printHTML);
        printWindow.document.close();

        // Wait for content to load, then print
        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        };
    }
}

// Make it globally available
window.printReceipt = PrintReceipt.print;
