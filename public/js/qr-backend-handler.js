/******/ (() => { // webpackBootstrap
/*!********************************************!*\
  !*** ./resources/js/qr-backend-handler.js ***!
  \********************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/**
 * QR Backend Handler
 * Handles backend communication specifically for QR scanner functionality
 * Focuses on QR code processing and fish box status updates via scanning
 */
var QRBackendHandler = /*#__PURE__*/function () {
  function QRBackendHandler() {
    _classCallCheck(this, QRBackendHandler);
    this.baseUrl = null;
    this.csrfToken = null;
    this.isProcessing = false;
  }

  /**
   * Initialize the backend handler with required tokens and URLs
   */
  return _createClass(QRBackendHandler, [{
    key: "initialize",
    value: function initialize() {
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
  }, {
    key: "getBaseUrl",
    value: function getBaseUrl() {
      var meta = document.querySelector('meta[name="fish-box-update-url"]');
      return meta ? meta.getAttribute('content') : null;
    }

    /**
     * Get CSRF token from meta tag
     */
  }, {
    key: "getCSRFToken",
    value: function getCSRFToken() {
      var meta = document.querySelector('meta[name="csrf-token"]');
      return meta ? meta.getAttribute('content') : null;
    }

    /**
     * Update fish box status via AJAX
     * @param {string} qrCode - QR code value
     * @returns {Promise<Object>} - Response object with success/error status
     */
  }, {
    key: "updateFishBoxStatus",
    value: (function () {
      var _updateFishBoxStatus = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee(qrCode) {
        var formData, response, result, _t;
        return _regenerator().w(function (_context) {
          while (1) switch (_context.p = _context.n) {
            case 0:
              if (!this.isProcessing) {
                _context.n = 1;
                break;
              }
              console.log('Already processing a request, ignoring...');
              return _context.a(2, {
                success: false,
                message: 'Request already in progress'
              });
            case 1:
              if (!(!this.baseUrl || !this.csrfToken)) {
                _context.n = 2;
                break;
              }
              console.error('Backend handler not properly initialized');
              return _context.a(2, {
                success: false,
                message: 'Configuration error. Please refresh the page.'
              });
            case 2:
              this.isProcessing = true;
              _context.p = 3;
              formData = new FormData();
              formData.append('qr_code', qrCode);
              formData.append('_token', this.csrfToken);
              _context.n = 4;
              return fetch(this.baseUrl, {
                method: 'POST',
                body: formData,
                headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'Accept': 'application/json'
                }
              });
            case 4:
              response = _context.v;
              _context.n = 5;
              return response.json();
            case 5:
              result = _context.v;
              if (!response.ok) {
                _context.n = 6;
                break;
              }
              return _context.a(2, {
                success: true,
                message: result.message || 'Fish box status updated successfully!',
                data: result.data || null
              });
            case 6:
              return _context.a(2, {
                success: false,
                message: result.message || 'Failed to update fish box status',
                errors: result.errors || null
              });
            case 7:
              _context.n = 9;
              break;
            case 8:
              _context.p = 8;
              _t = _context.v;
              console.error('Network error updating fish box status:', _t);
              return _context.a(2, {
                success: false,
                message: 'Network error. Please check your connection and try again.'
              });
            case 9:
              _context.p = 9;
              this.isProcessing = false;
              return _context.f(9);
            case 10:
              return _context.a(2);
          }
        }, _callee, this, [[3, 8, 9, 10]]);
      }));
      function updateFishBoxStatus(_x) {
        return _updateFishBoxStatus.apply(this, arguments);
      }
      return updateFishBoxStatus;
    }()
    /**
     * Get fish box details by QR code
     * @param {string} qrCode - QR code value
     * @returns {Promise<Object>} - Fish box details
     */
    )
  }, {
    key: "getFishBoxByQRCode",
    value: (function () {
      var _getFishBoxByQRCode = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee2(qrCode) {
        var response, _t2;
        return _regenerator().w(function (_context2) {
          while (1) switch (_context2.p = _context2.n) {
            case 0:
              _context2.p = 0;
              _context2.n = 1;
              return fetch("/api/fish-boxes/qr/".concat(encodeURIComponent(qrCode)), {
                method: 'GET',
                headers: {
                  'Accept': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest'
                }
              });
            case 1:
              response = _context2.v;
              if (!response.ok) {
                _context2.n = 3;
                break;
              }
              _context2.n = 2;
              return response.json();
            case 2:
              return _context2.a(2, _context2.v);
            case 3:
              return _context2.a(2, null);
            case 4:
              _context2.n = 6;
              break;
            case 5:
              _context2.p = 5;
              _t2 = _context2.v;
              console.error('Error fetching fish box details:', _t2);
              return _context2.a(2, null);
            case 6:
              return _context2.a(2);
          }
        }, _callee2, null, [[0, 5]]);
      }));
      function getFishBoxByQRCode(_x2) {
        return _getFishBoxByQRCode.apply(this, arguments);
      }
      return getFishBoxByQRCode;
    }()
    /**
     * Validate QR code format
     * @param {string} qrCode - QR code to validate
     * @returns {boolean} - Whether QR code format is valid
     */
    )
  }, {
    key: "validateQRCode",
    value: function validateQRCode(qrCode) {
      if (!qrCode || typeof qrCode !== 'string') {
        return false;
      }

      // Check if it looks like a UUID (common QR code format)
      var uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;

      // Also allow other formats (alphanumeric, etc.)
      var alphanumericRegex = /^[a-zA-Z0-9\-_]+$/;
      return uuidRegex.test(qrCode) || alphanumericRegex.test(qrCode);
    }

    /**
     * Show success notification
     * @param {string} message - Success message
     */
  }, {
    key: "showSuccess",
    value: function showSuccess(message) {
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
  }, {
    key: "showError",
    value: function showError(message) {
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
  }, {
    key: "showWarning",
    value: function showWarning(message) {
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
  }, {
    key: "showInfo",
    value: function showInfo(message) {
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
  }, {
    key: "handleQRScanResult",
    value: (function () {
      var _handleQRScanResult = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee3(qrCode) {
        var onSuccess,
          onError,
          errorMsg,
          result,
          _errorMsg,
          _args3 = arguments,
          _t3;
        return _regenerator().w(function (_context3) {
          while (1) switch (_context3.p = _context3.n) {
            case 0:
              onSuccess = _args3.length > 1 && _args3[1] !== undefined ? _args3[1] : null;
              onError = _args3.length > 2 && _args3[2] !== undefined ? _args3[2] : null;
              if (this.validateQRCode(qrCode)) {
                _context3.n = 1;
                break;
              }
              errorMsg = 'Invalid QR code format. Please scan a valid QR code.';
              this.showError(errorMsg);
              if (onError) onError(errorMsg);
              return _context3.a(2);
            case 1:
              // Show processing notification with SweetAlert
              this.showProcessingDialog();
              _context3.p = 2;
              _context3.n = 3;
              return this.updateFishBoxStatus(qrCode);
            case 3:
              result = _context3.v;
              // Close processing dialog
              this.closeProcessingDialog();
              if (result.success) {
                this.showSuccess(result.message);
                if (onSuccess) onSuccess(result);
              } else {
                this.showError(result.message);
                if (onError) onError(result.message);
              }
              _context3.n = 5;
              break;
            case 4:
              _context3.p = 4;
              _t3 = _context3.v;
              // Close processing dialog
              this.closeProcessingDialog();
              _errorMsg = 'Network error. Please check your connection and try again.';
              this.showError(_errorMsg);
              if (onError) onError(_errorMsg);
            case 5:
              return _context3.a(2);
          }
        }, _callee3, this, [[2, 4]]);
      }));
      function handleQRScanResult(_x3) {
        return _handleQRScanResult.apply(this, arguments);
      }
      return handleQRScanResult;
    }()
    /**
     * Show processing dialog with SweetAlert
     */
    )
  }, {
    key: "showProcessingDialog",
    value: function showProcessingDialog() {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Processing QR Code',
          text: 'Please wait while we process your QR code...',
          icon: 'info',
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          didOpen: function didOpen() {
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
  }, {
    key: "closeProcessingDialog",
    value: function closeProcessingDialog() {
      if (typeof Swal !== 'undefined') {
        Swal.close();
      }
    }
  }]);
}(); // Make the class available globally
window.QRBackendHandler = QRBackendHandler;
/******/ })()
;