/**
 * Sales Form Functionality
 * Handles dynamic sales detail rows, fish box selection, and calculations
 */

// Sales form configuration (initialized from server)
let SALES_CONFIG = {};

/**
 * Initialize sales form
 * @param {Object} config - Configuration object with fishBoxes, fishTypes, and detailIndex
 */
function initializeSalesForm(config) {
    SALES_CONFIG = config;

    const container = document.getElementById('sales-details-container');
    const addBtn = document.getElementById('add-sales-detail-btn');
    const totalAmountDisplay = document.getElementById('total-amount-display');

    if (!container || !addBtn || !totalAmountDisplay) return;

    // Get selected fish boxes (excluding a specific row)
    const getSelectedFishBoxes = (excludeRowIndex = null) => {
        return Array.from(document.querySelectorAll('.sales-detail-row'))
            .filter(row => row.dataset.index !== excludeRowIndex)
            .flatMap(row => Array.from(row.querySelectorAll('.fish-box-hidden-input'))
                .map(input => input.value)
                .filter(Boolean));
    };

    // Get available fish boxes for a fish type
    const getAvailableFishBoxesForType = (fishTypeId, excludeRowIndex = null) => {
        const selectedBoxes = getSelectedFishBoxes(excludeRowIndex);
        return SALES_CONFIG.fishBoxes.filter(box => {
            const boxFishTypeId = box.fish_type_id || box.fish_type?.id;
            return boxFishTypeId == fishTypeId && !selectedBoxes.includes(box.id.toString());
        });
    };

    // Update all rows fish box availability
    const updateAllRowsFishBoxAvailability = () => {
        document.querySelectorAll('.sales-detail-row').forEach(row => {
            const fishTypeSelect = row.querySelector('.fish-type-select');
            if (fishTypeSelect && fishTypeSelect.value) handleFishTypeChange(fishTypeSelect, true);
        });
    };

    // Add new sales detail
    addBtn.addEventListener('click', () => {
        const template = document.getElementById('sales-detail-row-template');
        if (!template) return;

        const newRow = template.content.cloneNode(true).querySelector('.sales-detail-row');
        newRow.dataset.index = SALES_CONFIG.detailIndex;
        newRow.innerHTML = newRow.innerHTML.replaceAll('INDEX', SALES_CONFIG.detailIndex);
        container.appendChild(newRow);
        SALES_CONFIG.detailIndex++;
        updateTotalAmount();
    });

    // Remove sales detail
    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-detail-btn') && container.children.length > 1) {
            e.target.closest('.sales-detail-row').remove();
            updateTotalAmount();
            updateAllRowsFishBoxAvailability();
        }
    });

    // Handle input changes
    container.addEventListener('change', (e) => {
        if (e.target.classList.contains('fish-type-select')) {
            handleFishTypeChange(e.target);
        } else if (e.target.classList.contains('unit-price-input') || e.target.classList.contains('quantity-input')) {
            calculateSubTotal(e.target);
            updateTotalAmount();
        }
    });

    container.addEventListener('input', (e) => {
        if (e.target.classList.contains('quantity-input')) {
            handleQuantityChange(e.target);
        } else if (e.target.classList.contains('unit-price-input')) {
            calculateSubTotal(e.target);
            updateTotalAmount();
        }
    });

    function handleQuantityChange(quantityInput) {
        const row = quantityInput.closest('.sales-detail-row');
        let quantity = parseInt(quantityInput.value) || 1;
        const fishBoxesContainer = row.querySelector('.fish-boxes-container');
        const fishTypeSelect = row.querySelector('.fish-type-select');

        if (fishTypeSelect.value) {
            const availableBoxes = getAvailableFishBoxesForType(fishTypeSelect.value, row.dataset.index);
            if (quantity > availableBoxes.length) {
                quantityInput.value = availableBoxes.length;
                quantity = availableBoxes.length; // Update the quantity variable
                toastr.warning(`Maximum quantity for this fish type is ${availableBoxes.length} (available fish boxes)`);
            }
        }

        fishBoxesContainer.innerHTML = '';
        for (let i = 0; i < quantity; i++) {
            const fishBoxItem = document.createElement('div');
            fishBoxItem.className = 'fish-box-item mb-2';
            fishBoxItem.innerHTML = `
                <select class="fish-box-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed" disabled>
                    <option value="">Auto-selected</option>
                </select>
                <input type="hidden" name="sales_details[${row.dataset.index}][box_id][]" class="fish-box-hidden-input">
            `;
            fishBoxesContainer.appendChild(fishBoxItem);
        }

        if (fishTypeSelect.value) handleFishTypeChange(fishTypeSelect);
        updateAllRowsFishBoxAvailability();

        // Calculate subtotal and update total
        calculateSubTotal(quantityInput);
        updateTotalAmount();
    }

    function handleFishTypeChange(fishTypeSelect, skipUpdate = false) {
        const row = fishTypeSelect.closest('.sales-detail-row');
        const fishTypeId = fishTypeSelect.value;
        const fishBoxesContainer = row.querySelector('.fish-boxes-container');
        const itemInput = row.querySelector('.item-input');

        if (fishTypeId) {
            const availableBoxes = getAvailableFishBoxesForType(fishTypeId, row.dataset.index);

            if (availableBoxes.length > 0) {
                const quantityInput = row.querySelector('.quantity-input');
                if (quantityInput) quantityInput.setAttribute('max', availableBoxes.length);

                fishBoxesContainer.querySelectorAll('.fish-box-item').forEach((item, index) => {
                    const fishBoxSelect = item.querySelector('.fish-box-select');
                    const fishBoxHiddenInput = item.querySelector('.fish-box-hidden-input');

                    if (availableBoxes[index]) {
                        const selectedBox = availableBoxes[index];
                        fishBoxHiddenInput.value = selectedBox.id;
                        fishBoxSelect.innerHTML = `<option value="${selectedBox.id}" selected>${selectedBox.name}</option>`;
                    } else {
                        fishBoxSelect.innerHTML = '<option value="">No more boxes available</option>';
                    }
                });

                const fishType = SALES_CONFIG.fishTypes.find(ft => ft.id == fishTypeId);
                if (fishType && itemInput) itemInput.value = fishType.name;

                // Only update other rows if not called from updateAllRowsFishBoxAvailability
                if (!skipUpdate) {
                    updateAllRowsFishBoxAvailability();
                }
            } else {
                fishBoxesContainer.querySelectorAll('.fish-box-select').forEach(select => {
                    select.innerHTML = '<option value="">No boxes available</option>';
                });
                toastr.error('No fish boxes available for the selected fish type.');
                fishTypeSelect.value = '';
                if (itemInput) itemInput.value = '';
            }
        } else {
            fishBoxesContainer.querySelectorAll('.fish-box-item').forEach(item => {
                item.querySelector('.fish-box-select').innerHTML = '<option value="">Auto-selected</option>';
                item.querySelector('.fish-box-hidden-input').value = '';
            });
        }
    }

    function calculateSubTotal(input) {
        const row = input.closest('.sales-detail-row');
        const unitPriceInput = row.querySelector('.unit-price-input');
        const quantityInput = row.querySelector('.quantity-input');
        const subTotalInput = row.querySelector('.sub-total-input');

        if (!unitPriceInput || !quantityInput || !subTotalInput) return;

        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        subTotalInput.value = (unitPrice * quantity).toFixed(2);
    }

    function updateTotalAmount() {
        const total = Array.from(document.querySelectorAll('.sub-total-input'))
            .reduce((sum, input) => sum + (parseFloat(input.value) || 0), 0);

        totalAmountDisplay.textContent = `₱${total.toFixed(2)}`;
        const totalAmountInput = document.getElementById('total_amount');
        if (totalAmountInput) totalAmountInput.value = total.toFixed(2);
    }

    // Initialize total amount
    updateTotalAmount();
}

// Make function available globally for browser use
window.initializeSalesForm = initializeSalesForm;

