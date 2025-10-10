/**
 * Print Broker Sales Report
 * Grabs data directly from the DOM table - no duplication!
 */
window.printBrokerSales = function(brokerId, brokerName, stallName) {
    // Get date range from URL or form inputs
    const urlParams = new URLSearchParams(window.location.search);
    let dateFrom = urlParams.get('date_from');
    let dateTo = urlParams.get('date_to');

    // If not in URL, try to get from the form inputs
    if (!dateFrom) {
        const dateFromInput = document.querySelector('input[name="date_from"]');
        if (dateFromInput) dateFrom = dateFromInput.value;
    }
    if (!dateTo) {
        const dateToInput = document.querySelector('input[name="date_to"]');
        if (dateToInput) dateTo = dateToInput.value;
    }

    // Format dates
    const formatDate = (dateStr) => {
        if (!dateStr) return '';
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    };

    const formattedDateFrom = formatDate(dateFrom);
    const formattedDateTo = formatDate(dateTo);

    // Find the broker's table in the DOM
    const brokerCard = document.querySelector(`[data-broker-id="${brokerId}"]`);
    if (!brokerCard) {
        toastr.error('Broker data not found');
        return;
    }

    // Get the table data from the DOM
    const table = brokerCard.querySelector('table');
    if (!table) {
        toastr.error('No sales table found for this broker');
        return;
    }

    // Build clean table HTML for printing
    let tableHTML = `
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f3f4f6;">Date</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f3f4f6;">Buyer</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f3f4f6;">Fish Type</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f3f4f6;">Quantity</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f3f4f6;">Fish Boxes</th>
                </tr>
            </thead>
            <tbody>
    `;

    // Parse table rows and rebuild with clean styling
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        tableHTML += '<tr>';
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, cellIndex) => {
            const rowspan = cell.getAttribute('rowspan');
            const rowspanAttr = rowspan ? ` rowspan="${rowspan}"` : '';

            // Check if this is the Fish Boxes column (last column)
            if (cellIndex === cells.length - 1) {
                // Get all fishbox badges
                const fishboxBadges = cell.querySelectorAll('span');
                let fishboxText = '';

                if (fishboxBadges.length > 0) {
                    const fishboxNames = Array.from(fishboxBadges).map(badge => badge.textContent.trim());
                    fishboxText = fishboxNames.join(', '); // Add comma between fishboxes
                } else {
                    fishboxText = cell.textContent.trim();
                }

                tableHTML += `<td${rowspanAttr} style="border: 1px solid #ddd; padding: 12px;">${fishboxText}</td>`;
            } else {
                tableHTML += `<td${rowspanAttr} style="border: 1px solid #ddd; padding: 12px;">${cell.textContent.trim()}</td>`;
            }
        });
        tableHTML += '</tr>';
    });

    tableHTML += '</tbody></table>';

    // Build stall info
    const stallInfo = stallName ? `<p><strong>Stall:</strong> ${stallName}</p>` : '';

    // Create print content
    const printContent = `
        <html>
            <head>
                <title>Sales Report - ${brokerName}</title>
                <style>
                    @media print {
                        body { margin: 0; }
                        @page { margin: 1cm; }
                    }
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 30px;
                        border-bottom: 2px solid #333;
                        padding-bottom: 20px;
                    }
                    .header h1 {
                        margin: 0;
                        font-size: 24px;
                    }
                    .header p {
                        margin: 5px 0;
                        color: #666;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 12px;
                        text-align: left;
                    }
                    th {
                        background-color: #f3f4f6;
                    }
                    .footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 12px;
                        color: #666;
                        border-top: 1px solid #ddd;
                        padding-top: 20px;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Sales Report</h1>
                    <p><strong>Broker:</strong> ${brokerName}</p>
                    ${stallInfo}
                    ${formattedDateFrom && formattedDateTo ? `<p><strong>Period:</strong> ${formattedDateFrom} to ${formattedDateTo}</p>` : ''}
                </div>
                ${tableHTML}
                <div class="footer">
                    <p>POS System - Sales Report</p>
                    <p><strong>Generated:</strong> ${new Date().toLocaleString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</p>
                </div>
            </body>
        </html>
    `;

    // Create iframe for printing
    const iframe = document.createElement('iframe');
    iframe.style.position = 'fixed';
    iframe.style.right = '0';
    iframe.style.bottom = '0';
    iframe.style.width = '0';
    iframe.style.height = '0';
    iframe.style.border = '0';
    document.body.appendChild(iframe);

    const iframeDoc = iframe.contentWindow.document;
    iframeDoc.open();
    iframeDoc.write(printContent);
    iframeDoc.close();

    // Print after content is loaded
    iframe.onload = function() {
        setTimeout(() => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();

            // Remove iframe after printing
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 1000);
        }, 250);
    };
};

