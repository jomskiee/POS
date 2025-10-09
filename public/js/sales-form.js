/******/ (() => { // webpackBootstrap
/*!************************************!*\
  !*** ./resources/js/sales-form.js ***!
  \************************************/
/**
 * Sales Form Functionality
 * Handles dynamic sales detail rows, fish box selection, and calculations
 */

// Sales form configuration (initialized from server)
var SALES_CONFIG = {};

/**
 * Initialize sales form
 * @param {Object} config - Configuration object with fishBoxes, fishTypes, and detailIndex
 */
function initializeSalesForm(config) {
  SALES_CONFIG = config;
  var container = document.getElementById('sales-details-container');
  var addBtn = document.getElementById('add-sales-detail-btn');
  var totalAmountDisplay = document.getElementById('total-amount-display');
  if (!container || !addBtn || !totalAmountDisplay) return;

  // Get selected fish boxes (excluding a specific row)
  var getSelectedFishBoxes = function getSelectedFishBoxes() {
    var excludeRowIndex = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    return Array.from(document.querySelectorAll('.sales-detail-row')).filter(function (row) {
      return row.dataset.index !== excludeRowIndex;
    }).flatMap(function (row) {
      return Array.from(row.querySelectorAll('.fish-box-hidden-input')).map(function (input) {
        return input.value;
      }).filter(Boolean);
    });
  };

  // Get available fish boxes for a fish type
  var getAvailableFishBoxesForType = function getAvailableFishBoxesForType(fishTypeId) {
    var excludeRowIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var selectedBoxes = getSelectedFishBoxes(excludeRowIndex);
    return SALES_CONFIG.fishBoxes.filter(function (box) {
      var _box$fish_type;
      var boxFishTypeId = box.fish_type_id || ((_box$fish_type = box.fish_type) === null || _box$fish_type === void 0 ? void 0 : _box$fish_type.id);
      return boxFishTypeId == fishTypeId && !selectedBoxes.includes(box.id.toString());
    });
  };

  // Update all rows fish box availability
  var updateAllRowsFishBoxAvailability = function updateAllRowsFishBoxAvailability() {
    document.querySelectorAll('.sales-detail-row').forEach(function (row) {
      var fishTypeSelect = row.querySelector('.fish-type-select');
      if (fishTypeSelect && fishTypeSelect.value) handleFishTypeChange(fishTypeSelect, true);
    });
  };

  // Add new sales detail
  addBtn.addEventListener('click', function () {
    var template = document.getElementById('sales-detail-row-template');
    if (!template) return;
    var newRow = template.content.cloneNode(true).querySelector('.sales-detail-row');
    newRow.dataset.index = SALES_CONFIG.detailIndex;
    newRow.innerHTML = newRow.innerHTML.replaceAll('INDEX', SALES_CONFIG.detailIndex);
    container.appendChild(newRow);
    SALES_CONFIG.detailIndex++;
    updateTotalAmount();
  });

  // Remove sales detail
  container.addEventListener('click', function (e) {
    if (e.target.closest('.remove-detail-btn') && container.children.length > 1) {
      e.target.closest('.sales-detail-row').remove();
      updateTotalAmount();
      updateAllRowsFishBoxAvailability();
    }
  });

  // Handle input changes
  container.addEventListener('change', function (e) {
    if (e.target.classList.contains('fish-type-select')) {
      handleFishTypeChange(e.target);
    } else if (e.target.classList.contains('unit-price-input') || e.target.classList.contains('quantity-input')) {
      calculateSubTotal(e.target);
      updateTotalAmount();
    }
  });
  container.addEventListener('input', function (e) {
    if (e.target.classList.contains('quantity-input')) {
      handleQuantityChange(e.target);
    } else if (e.target.classList.contains('unit-price-input')) {
      calculateSubTotal(e.target);
      updateTotalAmount();
    }
  });
  function handleQuantityChange(quantityInput) {
    var row = quantityInput.closest('.sales-detail-row');
    var quantity = parseInt(quantityInput.value) || 1;
    var fishBoxesContainer = row.querySelector('.fish-boxes-container');
    var fishTypeSelect = row.querySelector('.fish-type-select');
    if (fishTypeSelect.value) {
      var availableBoxes = getAvailableFishBoxesForType(fishTypeSelect.value, row.dataset.index);
      if (quantity > availableBoxes.length) {
        quantityInput.value = availableBoxes.length;
        quantity = availableBoxes.length; // Update the quantity variable
        toastr.warning("Maximum quantity for this fish type is ".concat(availableBoxes.length, " (available fish boxes)"));
      }
    }
    fishBoxesContainer.innerHTML = '';
    for (var i = 0; i < quantity; i++) {
      var fishBoxItem = document.createElement('div');
      fishBoxItem.className = 'fish-box-item mb-2';
      fishBoxItem.innerHTML = "\n                <select class=\"fish-box-select w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed\" disabled>\n                    <option value=\"\">Auto-selected</option>\n                </select>\n                <input type=\"hidden\" name=\"sales_details[".concat(row.dataset.index, "][box_id][]\" class=\"fish-box-hidden-input\">\n            ");
      fishBoxesContainer.appendChild(fishBoxItem);
    }
    if (fishTypeSelect.value) handleFishTypeChange(fishTypeSelect);
    updateAllRowsFishBoxAvailability();

    // Calculate subtotal and update total
    calculateSubTotal(quantityInput);
    updateTotalAmount();
  }
  function handleFishTypeChange(fishTypeSelect) {
    var skipUpdate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var row = fishTypeSelect.closest('.sales-detail-row');
    var fishTypeId = fishTypeSelect.value;
    var fishBoxesContainer = row.querySelector('.fish-boxes-container');
    var itemInput = row.querySelector('.item-input');
    if (fishTypeId) {
      var availableBoxes = getAvailableFishBoxesForType(fishTypeId, row.dataset.index);
      if (availableBoxes.length > 0) {
        var quantityInput = row.querySelector('.quantity-input');
        if (quantityInput) quantityInput.setAttribute('max', availableBoxes.length);
        fishBoxesContainer.querySelectorAll('.fish-box-item').forEach(function (item, index) {
          var fishBoxSelect = item.querySelector('.fish-box-select');
          var fishBoxHiddenInput = item.querySelector('.fish-box-hidden-input');
          if (availableBoxes[index]) {
            var selectedBox = availableBoxes[index];
            fishBoxHiddenInput.value = selectedBox.id;
            fishBoxSelect.innerHTML = "<option value=\"".concat(selectedBox.id, "\" selected>").concat(selectedBox.name, "</option>");
          } else {
            fishBoxSelect.innerHTML = '<option value="">No more boxes available</option>';
          }
        });
        var fishType = SALES_CONFIG.fishTypes.find(function (ft) {
          return ft.id == fishTypeId;
        });
        if (fishType && itemInput) itemInput.value = fishType.name;

        // Only update other rows if not called from updateAllRowsFishBoxAvailability
        if (!skipUpdate) {
          updateAllRowsFishBoxAvailability();
        }
      } else {
        fishBoxesContainer.querySelectorAll('.fish-box-select').forEach(function (select) {
          select.innerHTML = '<option value="">No boxes available</option>';
        });
        toastr.error('No fish boxes available for the selected fish type.');
        fishTypeSelect.value = '';
        if (itemInput) itemInput.value = '';
      }
    } else {
      fishBoxesContainer.querySelectorAll('.fish-box-item').forEach(function (item) {
        item.querySelector('.fish-box-select').innerHTML = '<option value="">Auto-selected</option>';
        item.querySelector('.fish-box-hidden-input').value = '';
      });
    }
  }
  function calculateSubTotal(input) {
    var row = input.closest('.sales-detail-row');
    var unitPriceInput = row.querySelector('.unit-price-input');
    var quantityInput = row.querySelector('.quantity-input');
    var subTotalInput = row.querySelector('.sub-total-input');
    if (!unitPriceInput || !quantityInput || !subTotalInput) return;
    var unitPrice = parseFloat(unitPriceInput.value) || 0;
    var quantity = parseInt(quantityInput.value) || 0;
    subTotalInput.value = (unitPrice * quantity).toFixed(2);
  }
  function updateTotalAmount() {
    var total = Array.from(document.querySelectorAll('.sub-total-input')).reduce(function (sum, input) {
      return sum + (parseFloat(input.value) || 0);
    }, 0);
    totalAmountDisplay.textContent = "\u20B1".concat(total.toFixed(2));
    var totalAmountInput = document.getElementById('total_amount');
    if (totalAmountInput) totalAmountInput.value = total.toFixed(2);
  }

  // Initialize total amount
  updateTotalAmount();
}

// Make function available globally for browser use
window.initializeSalesForm = initializeSalesForm;
/******/ })()
;