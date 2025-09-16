/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/print-receipt.js ***!
  \***************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/**
 * Print Receipt Functionality
 * Handles printing of sales receipts in a new window
 */
var PrintReceipt = /*#__PURE__*/function () {
  function PrintReceipt() {
    _classCallCheck(this, PrintReceipt);
  }
  return _createClass(PrintReceipt, null, [{
    key: "print",
    value:
    /**
     * Print a receipt from the receipt content element
     * @param {string} receiptId - The ID of the receipt content element
     * @param {string} receiptTitle - The title for the receipt window
     */
    function print() {
      var receiptId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'receipt-content';
      var receiptTitle = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'Receipt';
      // Get the receipt content
      var receiptContent = document.getElementById(receiptId);
      if (!receiptContent) {
        alert('Receipt content not found!');
        return;
      }

      // Create a new window for printing
      var printWindow = window.open('', '_blank', 'width=600,height=800,scrollbars=yes,resizable=yes');
      if (!printWindow) {
        alert('Please allow popups for this site to print receipts.');
        return;
      }

      // Get the actual content from the modal
      var modalContent = receiptContent.innerHTML;

      // Write the receipt content to the new window
      var receiptHtml = this.generateReceiptHtml(modalContent, receiptTitle);
      printWindow.document.write(receiptHtml);

      // Close the document
      printWindow.document.close();

      // Focus the window and auto-print
      printWindow.focus();

      // Auto-print after a short delay
      setTimeout(function () {
        printWindow.print();
      }, 500);
    }

    /**
     * Generate the complete HTML for the receipt
     * @param {string} modalContent - The content from the receipt modal
     * @param {string} title - The title for the receipt
     * @returns {string} Complete HTML string
     */
  }, {
    key: "generateReceiptHtml",
    value: function generateReceiptHtml(modalContent, title) {
      return '<!DOCTYPE html>' + '<html>' + '<head>' + '<title>' + title + '</title>' + '<meta charset="utf-8">' + '<style>' + this.getReceiptStyles() + '</style>' + '</head>' + '<body>' + '<div class="receipt">' + modalContent + '</div>' + '</body>' + '</html>';
    }

    /**
     * Get the CSS styles for the receipt
     * @returns {string} CSS styles
     */
  }, {
    key: "getReceiptStyles",
    value: function getReceiptStyles() {
      return '* { margin: 0; padding: 0; box-sizing: border-box; }' + 'body { font-family: "Courier New", monospace; font-size: 12px; line-height: 1.4; margin: 0; padding: 20px; background: white; color: black; }' + '.receipt { max-width: 300px; margin: 0 auto; background: white; }' + '.header { text-align: center; border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 15px; }' + '.header h1 { font-size: 18px; font-weight: bold; margin: 0 0 5px 0; }' + '.header p { margin: 0; font-size: 10px; }' + '.section { margin-bottom: 15px; }' + '.section-title { font-weight: bold; margin-bottom: 8px; font-size: 11px; }' + '.row { display: flex; justify-content: space-between; margin-bottom: 3px; font-size: 10px; }' + '.item { margin-bottom: 5px; font-size: 10px; }' + '.item-name { font-weight: bold; }' + '.item-details { font-size: 9px; color: #666; margin-left: 10px; }' + '.total-row { border-top: 1px solid #000; padding-top: 5px; font-weight: bold; }' + '.footer { text-align: center; border-top: 1px solid #000; padding-top: 10px; margin-top: 15px; font-size: 9px; }' + '.payment-history { font-size: 9px; }' + '.payment-item { display: flex; justify-content: space-between; margin-bottom: 3px; }' + '.space-y-2 > * + * { margin-top: 0.5rem; }' + '.space-y-3 > * + * { margin-top: 0.75rem; }' + '.space-y-4 > * + * { margin-top: 1rem; }' + '.grid { display: grid; }' + '.grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }' + '.grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }' + '.gap-6 { gap: 1.5rem; }' + '.md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }' + '@media (min-width: 768px) { .md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }' + '.mb-2 { margin-bottom: 0.5rem; }' + '.mb-3 { margin-bottom: 0.75rem; }' + '.mb-4 { margin-bottom: 1rem; }' + '.mb-6 { margin-bottom: 1.5rem; }' + '.mb-8 { margin-bottom: 2rem; }' + '.pt-2 { padding-top: 0.5rem; }' + '.pt-4 { padding-top: 1rem; }' + '.pb-4 { padding-bottom: 1rem; }' + '.px-4 { padding-left: 1rem; padding-right: 1rem; }' + '.py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }' + '.py-4 { padding-top: 1rem; padding-bottom: 1rem; }' + '.py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }' + '.text-center { text-align: center; }' + '.text-sm { font-size: 0.875rem; }' + '.text-xs { font-size: 0.75rem; }' + '.text-lg { font-size: 1.125rem; }' + '.text-xl { font-size: 1.25rem; }' + '.text-2xl { font-size: 1.5rem; }' + '.font-bold { font-weight: 700; }' + '.font-semibold { font-weight: 600; }' + '.font-medium { font-weight: 500; }' + '.text-gray-600 { color: #4b5563; }' + '.text-gray-900 { color: #111827; }' + '.text-green-600 { color: #059669; }' + '.text-orange-600 { color: #ea580c; }' + '.text-blue-600 { color: #2563eb; }' + '.text-purple-600 { color: #9333ea; }' + '.text-red-600 { color: #dc2626; }' + '.text-yellow-600 { color: #d97706; }' + '.text-indigo-600 { color: #4f46e5; }' + '.text-emerald-600 { color: #059669; }' + '.border-b { border-bottom-width: 1px; }' + '.border-t { border-top-width: 1px; }' + '.border-gray-200 { border-color: #e5e7eb; }' + '.rounded-lg { border-radius: 0.5rem; }' + '.rounded-xl { border-radius: 0.75rem; }' + '.rounded-full { border-radius: 9999px; }' + '.bg-gray-50 { background-color: #f9fafb; }' + '.bg-gray-100 { background-color: #f3f4f6; }' + '.bg-blue-100 { background-color: #dbeafe; }' + '.bg-green-100 { background-color: #dcfce7; }' + '.bg-yellow-100 { background-color: #fef3c7; }' + '.bg-orange-100 { background-color: #fed7aa; }' + '.bg-purple-100 { background-color: #e9d5ff; }' + '.bg-red-100 { background-color: #fee2e2; }' + '.bg-indigo-100 { background-color: #e0e7ff; }' + '.bg-emerald-100 { background-color: #d1fae5; }' + '.inline-flex { display: inline-flex; }' + '.items-center { align-items: center; }' + '.justify-between { justify-content: space-between; }' + '.justify-end { justify-content: flex-end; }' + '.flex { display: flex; }' + '.flex-1 { flex: 1 1 0%; }' + '.w-4 { width: 1rem; }' + '.w-5 { width: 1.25rem; }' + '.w-6 { width: 1.5rem; }' + '.w-8 { width: 2rem; }' + '.w-12 { width: 3rem; }' + '.w-16 { width: 4rem; }' + '.h-4 { height: 1rem; }' + '.h-5 { height: 1.25rem; }' + '.h-6 { height: 1.5rem; }' + '.h-8 { height: 2rem; }' + '.h-12 { height: 3rem; }' + '.h-16 { height: 4rem; }' + '.mr-1 { margin-right: 0.25rem; }' + '.mr-2 { margin-right: 0.5rem; }' + '.mr-3 { margin-right: 0.75rem; }' + '.ml-2 { margin-left: 0.5rem; }' + '.px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }' + '.px-2\\.5 { padding-left: 0.625rem; padding-right: 0.625rem; }' + '.px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }' + '.px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }' + '.px-8 { padding-left: 2rem; padding-right: 2rem; }' + '.py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }' + '.py-0\\.5 { padding-top: 0.125rem; padding-bottom: 0.125rem; }' + '.py-1\\.5 { padding-top: 0.375rem; padding-bottom: 0.375rem; }' + '.py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }' + '.py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }' + '.py-8 { padding-top: 2rem; padding-bottom: 2rem; }' + '.py-12 { padding-top: 3rem; padding-bottom: 3rem; }' + '.p-1 { padding: 0.25rem; }' + '.p-1\\.5 { padding: 0.375rem; }' + '.p-2 { padding: 0.5rem; }' + '.p-4 { padding: 1rem; }' + '.p-6 { padding: 1.5rem; }' + '.p-8 { padding: 2rem; }' + '.max-w-md { max-width: 28rem; }' + '.mx-auto { margin-left: auto; margin-right: auto; }' + '.whitespace-nowrap { white-space: nowrap; }' + '.divide-y > * + * { border-top-width: 1px; }' + '.divide-gray-200 > * + * { border-color: #e5e7eb; }' + '.hover\\:bg-gray-50:hover { background-color: #f9fafb; }' + '.hover\\:bg-gray-100:hover { background-color: #f3f4f6; }' + '.hover\\:bg-blue-50:hover { background-color: #eff6ff; }' + '.hover\\:bg-green-50:hover { background-color: #f0fdf4; }' + '.hover\\:bg-red-50:hover { background-color: #fef2f2; }' + '.hover\\:text-green-900:hover { color: #14532d; }' + '.hover\\:text-blue-900:hover { color: #1e3a8a; }' + '.hover\\:text-purple-900:hover { color: #581c87; }' + '.hover\\:text-red-900:hover { color: #7f1d1d; }' + '.hover\\:text-gray-600:hover { color: #4b5563; }' + '.transition-colors { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }' + '.shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); }' + '.shadow-lg { box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }' + '.border { border-width: 1px; }' + '.border-l-4 { border-left-width: 4px; }' + '.border-yellow-400 { border-color: #facc15; }' + '.overflow-hidden { overflow: hidden; }' + '.overflow-x-auto { overflow-x: auto; }' + '.overflow-y-auto { overflow-y: auto; }' + '.min-w-full { min-width: 100%; }' + '.min-w-0 { min-width: 0px; }' + '.max-h-\\[70vh\\] { max-height: 70vh; }' + '.bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }' + '.from-blue-600 { --tw-gradient-from: #2563eb; --tw-gradient-to: rgb(37 99 235 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }' + '.to-blue-700 { --tw-gradient-to: #1d4ed8; }' + '.text-white { color: #ffffff; }' + '.text-blue-100 { color: #dbeafe; }' + '.text-blue-800 { color: #1e40af; }' + '.text-green-800 { color: #14532d; }' + '.text-yellow-800 { color: #92400e; }' + '.text-orange-800 { color: #9a3412; }' + '.text-purple-800 { color: #6b21a8; }' + '.text-red-800 { color: #991b1b; }' + '.text-indigo-800 { color: #3730a3; }' + '.text-emerald-800 { color: #065f46; }' + '.text-gray-500 { color: #6b7280; }' + '.text-gray-400 { color: #9ca3af; }' + '.text-gray-700 { color: #374151; }' + '.text-gray-900 { color: #111827; }' + '.bg-white { background-color: #ffffff; }' + '.bg-gray-50 { background-color: #f9fafb; }' + '.bg-gray-100 { background-color: #f3f4f6; }' + '.bg-blue-100 { background-color: #dbeafe; }' + '.bg-green-100 { background-color: #dcfce7; }' + '.bg-yellow-100 { background-color: #fef3c7; }' + '.bg-orange-100 { background-color: #fed7aa; }' + '.bg-purple-100 { background-color: #e9d5ff; }' + '.bg-red-100 { background-color: #fee2e2; }' + '.bg-indigo-100 { background-color: #e0e7ff; }' + '.bg-emerald-100 { background-color: #d1fae5; }' + '.bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }' + '.from-green-500 { --tw-gradient-from: #10b981; --tw-gradient-to: rgb(16 185 129 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }' + '.to-green-600 { --tw-gradient-to: #059669; }' + '.h-3 { height: 0.75rem; }' + '.w-full { width: 100%; }' + '.rounded-full { border-radius: 9999px; }' + '.transition-all { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }' + '.duration-300 { transition-duration: 300ms; }' + '@media print { body { margin: 0; padding: 10px; -webkit-print-color-adjust: exact; print-color-adjust: exact; } .receipt { max-width: none; margin: 0; } @page { margin: 0.5in; size: auto; } }';
    }
  }]);
}(); // Make PrintReceipt available globally
window.PrintReceipt = PrintReceipt;

// Legacy function for backward compatibility
window.printReceipt = function () {
  var receiptId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'receipt-content';
  var receiptTitle = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'Receipt';
  PrintReceipt.print(receiptId, receiptTitle);
};
/******/ })()
;