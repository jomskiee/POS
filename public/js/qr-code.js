/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/base64-js/index.js":
/*!*****************************************!*\
  !*** ./node_modules/base64-js/index.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


exports.byteLength = byteLength
exports.toByteArray = toByteArray
exports.fromByteArray = fromByteArray

var lookup = []
var revLookup = []
var Arr = typeof Uint8Array !== 'undefined' ? Uint8Array : Array

var code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/'
for (var i = 0, len = code.length; i < len; ++i) {
  lookup[i] = code[i]
  revLookup[code.charCodeAt(i)] = i
}

// Support decoding URL-safe base64 strings, as Node.js does.
// See: https://en.wikipedia.org/wiki/Base64#URL_applications
revLookup['-'.charCodeAt(0)] = 62
revLookup['_'.charCodeAt(0)] = 63

function getLens (b64) {
  var len = b64.length

  if (len % 4 > 0) {
    throw new Error('Invalid string. Length must be a multiple of 4')
  }

  // Trim off extra bytes after placeholder bytes are found
  // See: https://github.com/beatgammit/base64-js/issues/42
  var validLen = b64.indexOf('=')
  if (validLen === -1) validLen = len

  var placeHoldersLen = validLen === len
    ? 0
    : 4 - (validLen % 4)

  return [validLen, placeHoldersLen]
}

// base64 is 4/3 + up to two characters of the original data
function byteLength (b64) {
  var lens = getLens(b64)
  var validLen = lens[0]
  var placeHoldersLen = lens[1]
  return ((validLen + placeHoldersLen) * 3 / 4) - placeHoldersLen
}

function _byteLength (b64, validLen, placeHoldersLen) {
  return ((validLen + placeHoldersLen) * 3 / 4) - placeHoldersLen
}

function toByteArray (b64) {
  var tmp
  var lens = getLens(b64)
  var validLen = lens[0]
  var placeHoldersLen = lens[1]

  var arr = new Arr(_byteLength(b64, validLen, placeHoldersLen))

  var curByte = 0

  // if there are placeholders, only get up to the last complete 4 chars
  var len = placeHoldersLen > 0
    ? validLen - 4
    : validLen

  var i
  for (i = 0; i < len; i += 4) {
    tmp =
      (revLookup[b64.charCodeAt(i)] << 18) |
      (revLookup[b64.charCodeAt(i + 1)] << 12) |
      (revLookup[b64.charCodeAt(i + 2)] << 6) |
      revLookup[b64.charCodeAt(i + 3)]
    arr[curByte++] = (tmp >> 16) & 0xFF
    arr[curByte++] = (tmp >> 8) & 0xFF
    arr[curByte++] = tmp & 0xFF
  }

  if (placeHoldersLen === 2) {
    tmp =
      (revLookup[b64.charCodeAt(i)] << 2) |
      (revLookup[b64.charCodeAt(i + 1)] >> 4)
    arr[curByte++] = tmp & 0xFF
  }

  if (placeHoldersLen === 1) {
    tmp =
      (revLookup[b64.charCodeAt(i)] << 10) |
      (revLookup[b64.charCodeAt(i + 1)] << 4) |
      (revLookup[b64.charCodeAt(i + 2)] >> 2)
    arr[curByte++] = (tmp >> 8) & 0xFF
    arr[curByte++] = tmp & 0xFF
  }

  return arr
}

function tripletToBase64 (num) {
  return lookup[num >> 18 & 0x3F] +
    lookup[num >> 12 & 0x3F] +
    lookup[num >> 6 & 0x3F] +
    lookup[num & 0x3F]
}

function encodeChunk (uint8, start, end) {
  var tmp
  var output = []
  for (var i = start; i < end; i += 3) {
    tmp =
      ((uint8[i] << 16) & 0xFF0000) +
      ((uint8[i + 1] << 8) & 0xFF00) +
      (uint8[i + 2] & 0xFF)
    output.push(tripletToBase64(tmp))
  }
  return output.join('')
}

function fromByteArray (uint8) {
  var tmp
  var len = uint8.length
  var extraBytes = len % 3 // if we have 1 byte left, pad 2 bytes
  var parts = []
  var maxChunkLength = 16383 // must be multiple of 3

  // go through the array every three bytes, we'll deal with trailing stuff later
  for (var i = 0, len2 = len - extraBytes; i < len2; i += maxChunkLength) {
    parts.push(encodeChunk(uint8, i, (i + maxChunkLength) > len2 ? len2 : (i + maxChunkLength)))
  }

  // pad the end with zeros, but make sure to not forget the extra bytes
  if (extraBytes === 1) {
    tmp = uint8[len - 1]
    parts.push(
      lookup[tmp >> 2] +
      lookup[(tmp << 4) & 0x3F] +
      '=='
    )
  } else if (extraBytes === 2) {
    tmp = (uint8[len - 2] << 8) + uint8[len - 1]
    parts.push(
      lookup[tmp >> 10] +
      lookup[(tmp >> 4) & 0x3F] +
      lookup[(tmp << 2) & 0x3F] +
      '='
    )
  }

  return parts.join('')
}


/***/ }),

/***/ "./node_modules/buffer/index.js":
/*!**************************************!*\
  !*** ./node_modules/buffer/index.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";
/*!
 * The buffer module from node.js, for the browser.
 *
 * @author   Feross Aboukhadijeh <http://feross.org>
 * @license  MIT
 */
/* eslint-disable no-proto */



var base64 = __webpack_require__(/*! base64-js */ "./node_modules/base64-js/index.js")
var ieee754 = __webpack_require__(/*! ieee754 */ "./node_modules/ieee754/index.js")
var isArray = __webpack_require__(/*! isarray */ "./node_modules/isarray/index.js")

exports.Buffer = Buffer
exports.SlowBuffer = SlowBuffer
exports.INSPECT_MAX_BYTES = 50

/**
 * If `Buffer.TYPED_ARRAY_SUPPORT`:
 *   === true    Use Uint8Array implementation (fastest)
 *   === false   Use Object implementation (most compatible, even IE6)
 *
 * Browsers that support typed arrays are IE 10+, Firefox 4+, Chrome 7+, Safari 5.1+,
 * Opera 11.6+, iOS 4.2+.
 *
 * Due to various browser bugs, sometimes the Object implementation will be used even
 * when the browser supports typed arrays.
 *
 * Note:
 *
 *   - Firefox 4-29 lacks support for adding new properties to `Uint8Array` instances,
 *     See: https://bugzilla.mozilla.org/show_bug.cgi?id=695438.
 *
 *   - Chrome 9-10 is missing the `TypedArray.prototype.subarray` function.
 *
 *   - IE10 has a broken `TypedArray.prototype.subarray` function which returns arrays of
 *     incorrect length in some situations.

 * We detect these buggy browsers and set `Buffer.TYPED_ARRAY_SUPPORT` to `false` so they
 * get the Object implementation, which is slower but behaves correctly.
 */
Buffer.TYPED_ARRAY_SUPPORT = __webpack_require__.g.TYPED_ARRAY_SUPPORT !== undefined
  ? __webpack_require__.g.TYPED_ARRAY_SUPPORT
  : typedArraySupport()

/*
 * Export kMaxLength after typed array support is determined.
 */
exports.kMaxLength = kMaxLength()

function typedArraySupport () {
  try {
    var arr = new Uint8Array(1)
    arr.__proto__ = {__proto__: Uint8Array.prototype, foo: function () { return 42 }}
    return arr.foo() === 42 && // typed array instances can be augmented
        typeof arr.subarray === 'function' && // chrome 9-10 lack `subarray`
        arr.subarray(1, 1).byteLength === 0 // ie10 has broken `subarray`
  } catch (e) {
    return false
  }
}

function kMaxLength () {
  return Buffer.TYPED_ARRAY_SUPPORT
    ? 0x7fffffff
    : 0x3fffffff
}

function createBuffer (that, length) {
  if (kMaxLength() < length) {
    throw new RangeError('Invalid typed array length')
  }
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    // Return an augmented `Uint8Array` instance, for best performance
    that = new Uint8Array(length)
    that.__proto__ = Buffer.prototype
  } else {
    // Fallback: Return an object instance of the Buffer class
    if (that === null) {
      that = new Buffer(length)
    }
    that.length = length
  }

  return that
}

/**
 * The Buffer constructor returns instances of `Uint8Array` that have their
 * prototype changed to `Buffer.prototype`. Furthermore, `Buffer` is a subclass of
 * `Uint8Array`, so the returned instances will have all the node `Buffer` methods
 * and the `Uint8Array` methods. Square bracket notation works as expected -- it
 * returns a single octet.
 *
 * The `Uint8Array` prototype remains unmodified.
 */

function Buffer (arg, encodingOrOffset, length) {
  if (!Buffer.TYPED_ARRAY_SUPPORT && !(this instanceof Buffer)) {
    return new Buffer(arg, encodingOrOffset, length)
  }

  // Common case.
  if (typeof arg === 'number') {
    if (typeof encodingOrOffset === 'string') {
      throw new Error(
        'If encoding is specified then the first argument must be a string'
      )
    }
    return allocUnsafe(this, arg)
  }
  return from(this, arg, encodingOrOffset, length)
}

Buffer.poolSize = 8192 // not used by this implementation

// TODO: Legacy, not needed anymore. Remove in next major version.
Buffer._augment = function (arr) {
  arr.__proto__ = Buffer.prototype
  return arr
}

function from (that, value, encodingOrOffset, length) {
  if (typeof value === 'number') {
    throw new TypeError('"value" argument must not be a number')
  }

  if (typeof ArrayBuffer !== 'undefined' && value instanceof ArrayBuffer) {
    return fromArrayBuffer(that, value, encodingOrOffset, length)
  }

  if (typeof value === 'string') {
    return fromString(that, value, encodingOrOffset)
  }

  return fromObject(that, value)
}

/**
 * Functionally equivalent to Buffer(arg, encoding) but throws a TypeError
 * if value is a number.
 * Buffer.from(str[, encoding])
 * Buffer.from(array)
 * Buffer.from(buffer)
 * Buffer.from(arrayBuffer[, byteOffset[, length]])
 **/
Buffer.from = function (value, encodingOrOffset, length) {
  return from(null, value, encodingOrOffset, length)
}

if (Buffer.TYPED_ARRAY_SUPPORT) {
  Buffer.prototype.__proto__ = Uint8Array.prototype
  Buffer.__proto__ = Uint8Array
  if (typeof Symbol !== 'undefined' && Symbol.species &&
      Buffer[Symbol.species] === Buffer) {
    // Fix subarray() in ES2016. See: https://github.com/feross/buffer/pull/97
    Object.defineProperty(Buffer, Symbol.species, {
      value: null,
      configurable: true
    })
  }
}

function assertSize (size) {
  if (typeof size !== 'number') {
    throw new TypeError('"size" argument must be a number')
  } else if (size < 0) {
    throw new RangeError('"size" argument must not be negative')
  }
}

function alloc (that, size, fill, encoding) {
  assertSize(size)
  if (size <= 0) {
    return createBuffer(that, size)
  }
  if (fill !== undefined) {
    // Only pay attention to encoding if it's a string. This
    // prevents accidentally sending in a number that would
    // be interpretted as a start offset.
    return typeof encoding === 'string'
      ? createBuffer(that, size).fill(fill, encoding)
      : createBuffer(that, size).fill(fill)
  }
  return createBuffer(that, size)
}

/**
 * Creates a new filled Buffer instance.
 * alloc(size[, fill[, encoding]])
 **/
Buffer.alloc = function (size, fill, encoding) {
  return alloc(null, size, fill, encoding)
}

function allocUnsafe (that, size) {
  assertSize(size)
  that = createBuffer(that, size < 0 ? 0 : checked(size) | 0)
  if (!Buffer.TYPED_ARRAY_SUPPORT) {
    for (var i = 0; i < size; ++i) {
      that[i] = 0
    }
  }
  return that
}

/**
 * Equivalent to Buffer(num), by default creates a non-zero-filled Buffer instance.
 * */
Buffer.allocUnsafe = function (size) {
  return allocUnsafe(null, size)
}
/**
 * Equivalent to SlowBuffer(num), by default creates a non-zero-filled Buffer instance.
 */
Buffer.allocUnsafeSlow = function (size) {
  return allocUnsafe(null, size)
}

function fromString (that, string, encoding) {
  if (typeof encoding !== 'string' || encoding === '') {
    encoding = 'utf8'
  }

  if (!Buffer.isEncoding(encoding)) {
    throw new TypeError('"encoding" must be a valid string encoding')
  }

  var length = byteLength(string, encoding) | 0
  that = createBuffer(that, length)

  var actual = that.write(string, encoding)

  if (actual !== length) {
    // Writing a hex string, for example, that contains invalid characters will
    // cause everything after the first invalid character to be ignored. (e.g.
    // 'abxxcd' will be treated as 'ab')
    that = that.slice(0, actual)
  }

  return that
}

function fromArrayLike (that, array) {
  var length = array.length < 0 ? 0 : checked(array.length) | 0
  that = createBuffer(that, length)
  for (var i = 0; i < length; i += 1) {
    that[i] = array[i] & 255
  }
  return that
}

function fromArrayBuffer (that, array, byteOffset, length) {
  array.byteLength // this throws if `array` is not a valid ArrayBuffer

  if (byteOffset < 0 || array.byteLength < byteOffset) {
    throw new RangeError('\'offset\' is out of bounds')
  }

  if (array.byteLength < byteOffset + (length || 0)) {
    throw new RangeError('\'length\' is out of bounds')
  }

  if (byteOffset === undefined && length === undefined) {
    array = new Uint8Array(array)
  } else if (length === undefined) {
    array = new Uint8Array(array, byteOffset)
  } else {
    array = new Uint8Array(array, byteOffset, length)
  }

  if (Buffer.TYPED_ARRAY_SUPPORT) {
    // Return an augmented `Uint8Array` instance, for best performance
    that = array
    that.__proto__ = Buffer.prototype
  } else {
    // Fallback: Return an object instance of the Buffer class
    that = fromArrayLike(that, array)
  }
  return that
}

function fromObject (that, obj) {
  if (Buffer.isBuffer(obj)) {
    var len = checked(obj.length) | 0
    that = createBuffer(that, len)

    if (that.length === 0) {
      return that
    }

    obj.copy(that, 0, 0, len)
    return that
  }

  if (obj) {
    if ((typeof ArrayBuffer !== 'undefined' &&
        obj.buffer instanceof ArrayBuffer) || 'length' in obj) {
      if (typeof obj.length !== 'number' || isnan(obj.length)) {
        return createBuffer(that, 0)
      }
      return fromArrayLike(that, obj)
    }

    if (obj.type === 'Buffer' && isArray(obj.data)) {
      return fromArrayLike(that, obj.data)
    }
  }

  throw new TypeError('First argument must be a string, Buffer, ArrayBuffer, Array, or array-like object.')
}

function checked (length) {
  // Note: cannot use `length < kMaxLength()` here because that fails when
  // length is NaN (which is otherwise coerced to zero.)
  if (length >= kMaxLength()) {
    throw new RangeError('Attempt to allocate Buffer larger than maximum ' +
                         'size: 0x' + kMaxLength().toString(16) + ' bytes')
  }
  return length | 0
}

function SlowBuffer (length) {
  if (+length != length) { // eslint-disable-line eqeqeq
    length = 0
  }
  return Buffer.alloc(+length)
}

Buffer.isBuffer = function isBuffer (b) {
  return !!(b != null && b._isBuffer)
}

Buffer.compare = function compare (a, b) {
  if (!Buffer.isBuffer(a) || !Buffer.isBuffer(b)) {
    throw new TypeError('Arguments must be Buffers')
  }

  if (a === b) return 0

  var x = a.length
  var y = b.length

  for (var i = 0, len = Math.min(x, y); i < len; ++i) {
    if (a[i] !== b[i]) {
      x = a[i]
      y = b[i]
      break
    }
  }

  if (x < y) return -1
  if (y < x) return 1
  return 0
}

Buffer.isEncoding = function isEncoding (encoding) {
  switch (String(encoding).toLowerCase()) {
    case 'hex':
    case 'utf8':
    case 'utf-8':
    case 'ascii':
    case 'latin1':
    case 'binary':
    case 'base64':
    case 'ucs2':
    case 'ucs-2':
    case 'utf16le':
    case 'utf-16le':
      return true
    default:
      return false
  }
}

Buffer.concat = function concat (list, length) {
  if (!isArray(list)) {
    throw new TypeError('"list" argument must be an Array of Buffers')
  }

  if (list.length === 0) {
    return Buffer.alloc(0)
  }

  var i
  if (length === undefined) {
    length = 0
    for (i = 0; i < list.length; ++i) {
      length += list[i].length
    }
  }

  var buffer = Buffer.allocUnsafe(length)
  var pos = 0
  for (i = 0; i < list.length; ++i) {
    var buf = list[i]
    if (!Buffer.isBuffer(buf)) {
      throw new TypeError('"list" argument must be an Array of Buffers')
    }
    buf.copy(buffer, pos)
    pos += buf.length
  }
  return buffer
}

function byteLength (string, encoding) {
  if (Buffer.isBuffer(string)) {
    return string.length
  }
  if (typeof ArrayBuffer !== 'undefined' && typeof ArrayBuffer.isView === 'function' &&
      (ArrayBuffer.isView(string) || string instanceof ArrayBuffer)) {
    return string.byteLength
  }
  if (typeof string !== 'string') {
    string = '' + string
  }

  var len = string.length
  if (len === 0) return 0

  // Use a for loop to avoid recursion
  var loweredCase = false
  for (;;) {
    switch (encoding) {
      case 'ascii':
      case 'latin1':
      case 'binary':
        return len
      case 'utf8':
      case 'utf-8':
      case undefined:
        return utf8ToBytes(string).length
      case 'ucs2':
      case 'ucs-2':
      case 'utf16le':
      case 'utf-16le':
        return len * 2
      case 'hex':
        return len >>> 1
      case 'base64':
        return base64ToBytes(string).length
      default:
        if (loweredCase) return utf8ToBytes(string).length // assume utf8
        encoding = ('' + encoding).toLowerCase()
        loweredCase = true
    }
  }
}
Buffer.byteLength = byteLength

function slowToString (encoding, start, end) {
  var loweredCase = false

  // No need to verify that "this.length <= MAX_UINT32" since it's a read-only
  // property of a typed array.

  // This behaves neither like String nor Uint8Array in that we set start/end
  // to their upper/lower bounds if the value passed is out of range.
  // undefined is handled specially as per ECMA-262 6th Edition,
  // Section 13.3.3.7 Runtime Semantics: KeyedBindingInitialization.
  if (start === undefined || start < 0) {
    start = 0
  }
  // Return early if start > this.length. Done here to prevent potential uint32
  // coercion fail below.
  if (start > this.length) {
    return ''
  }

  if (end === undefined || end > this.length) {
    end = this.length
  }

  if (end <= 0) {
    return ''
  }

  // Force coersion to uint32. This will also coerce falsey/NaN values to 0.
  end >>>= 0
  start >>>= 0

  if (end <= start) {
    return ''
  }

  if (!encoding) encoding = 'utf8'

  while (true) {
    switch (encoding) {
      case 'hex':
        return hexSlice(this, start, end)

      case 'utf8':
      case 'utf-8':
        return utf8Slice(this, start, end)

      case 'ascii':
        return asciiSlice(this, start, end)

      case 'latin1':
      case 'binary':
        return latin1Slice(this, start, end)

      case 'base64':
        return base64Slice(this, start, end)

      case 'ucs2':
      case 'ucs-2':
      case 'utf16le':
      case 'utf-16le':
        return utf16leSlice(this, start, end)

      default:
        if (loweredCase) throw new TypeError('Unknown encoding: ' + encoding)
        encoding = (encoding + '').toLowerCase()
        loweredCase = true
    }
  }
}

// The property is used by `Buffer.isBuffer` and `is-buffer` (in Safari 5-7) to detect
// Buffer instances.
Buffer.prototype._isBuffer = true

function swap (b, n, m) {
  var i = b[n]
  b[n] = b[m]
  b[m] = i
}

Buffer.prototype.swap16 = function swap16 () {
  var len = this.length
  if (len % 2 !== 0) {
    throw new RangeError('Buffer size must be a multiple of 16-bits')
  }
  for (var i = 0; i < len; i += 2) {
    swap(this, i, i + 1)
  }
  return this
}

Buffer.prototype.swap32 = function swap32 () {
  var len = this.length
  if (len % 4 !== 0) {
    throw new RangeError('Buffer size must be a multiple of 32-bits')
  }
  for (var i = 0; i < len; i += 4) {
    swap(this, i, i + 3)
    swap(this, i + 1, i + 2)
  }
  return this
}

Buffer.prototype.swap64 = function swap64 () {
  var len = this.length
  if (len % 8 !== 0) {
    throw new RangeError('Buffer size must be a multiple of 64-bits')
  }
  for (var i = 0; i < len; i += 8) {
    swap(this, i, i + 7)
    swap(this, i + 1, i + 6)
    swap(this, i + 2, i + 5)
    swap(this, i + 3, i + 4)
  }
  return this
}

Buffer.prototype.toString = function toString () {
  var length = this.length | 0
  if (length === 0) return ''
  if (arguments.length === 0) return utf8Slice(this, 0, length)
  return slowToString.apply(this, arguments)
}

Buffer.prototype.equals = function equals (b) {
  if (!Buffer.isBuffer(b)) throw new TypeError('Argument must be a Buffer')
  if (this === b) return true
  return Buffer.compare(this, b) === 0
}

Buffer.prototype.inspect = function inspect () {
  var str = ''
  var max = exports.INSPECT_MAX_BYTES
  if (this.length > 0) {
    str = this.toString('hex', 0, max).match(/.{2}/g).join(' ')
    if (this.length > max) str += ' ... '
  }
  return '<Buffer ' + str + '>'
}

Buffer.prototype.compare = function compare (target, start, end, thisStart, thisEnd) {
  if (!Buffer.isBuffer(target)) {
    throw new TypeError('Argument must be a Buffer')
  }

  if (start === undefined) {
    start = 0
  }
  if (end === undefined) {
    end = target ? target.length : 0
  }
  if (thisStart === undefined) {
    thisStart = 0
  }
  if (thisEnd === undefined) {
    thisEnd = this.length
  }

  if (start < 0 || end > target.length || thisStart < 0 || thisEnd > this.length) {
    throw new RangeError('out of range index')
  }

  if (thisStart >= thisEnd && start >= end) {
    return 0
  }
  if (thisStart >= thisEnd) {
    return -1
  }
  if (start >= end) {
    return 1
  }

  start >>>= 0
  end >>>= 0
  thisStart >>>= 0
  thisEnd >>>= 0

  if (this === target) return 0

  var x = thisEnd - thisStart
  var y = end - start
  var len = Math.min(x, y)

  var thisCopy = this.slice(thisStart, thisEnd)
  var targetCopy = target.slice(start, end)

  for (var i = 0; i < len; ++i) {
    if (thisCopy[i] !== targetCopy[i]) {
      x = thisCopy[i]
      y = targetCopy[i]
      break
    }
  }

  if (x < y) return -1
  if (y < x) return 1
  return 0
}

// Finds either the first index of `val` in `buffer` at offset >= `byteOffset`,
// OR the last index of `val` in `buffer` at offset <= `byteOffset`.
//
// Arguments:
// - buffer - a Buffer to search
// - val - a string, Buffer, or number
// - byteOffset - an index into `buffer`; will be clamped to an int32
// - encoding - an optional encoding, relevant is val is a string
// - dir - true for indexOf, false for lastIndexOf
function bidirectionalIndexOf (buffer, val, byteOffset, encoding, dir) {
  // Empty buffer means no match
  if (buffer.length === 0) return -1

  // Normalize byteOffset
  if (typeof byteOffset === 'string') {
    encoding = byteOffset
    byteOffset = 0
  } else if (byteOffset > 0x7fffffff) {
    byteOffset = 0x7fffffff
  } else if (byteOffset < -0x80000000) {
    byteOffset = -0x80000000
  }
  byteOffset = +byteOffset  // Coerce to Number.
  if (isNaN(byteOffset)) {
    // byteOffset: it it's undefined, null, NaN, "foo", etc, search whole buffer
    byteOffset = dir ? 0 : (buffer.length - 1)
  }

  // Normalize byteOffset: negative offsets start from the end of the buffer
  if (byteOffset < 0) byteOffset = buffer.length + byteOffset
  if (byteOffset >= buffer.length) {
    if (dir) return -1
    else byteOffset = buffer.length - 1
  } else if (byteOffset < 0) {
    if (dir) byteOffset = 0
    else return -1
  }

  // Normalize val
  if (typeof val === 'string') {
    val = Buffer.from(val, encoding)
  }

  // Finally, search either indexOf (if dir is true) or lastIndexOf
  if (Buffer.isBuffer(val)) {
    // Special case: looking for empty string/buffer always fails
    if (val.length === 0) {
      return -1
    }
    return arrayIndexOf(buffer, val, byteOffset, encoding, dir)
  } else if (typeof val === 'number') {
    val = val & 0xFF // Search for a byte value [0-255]
    if (Buffer.TYPED_ARRAY_SUPPORT &&
        typeof Uint8Array.prototype.indexOf === 'function') {
      if (dir) {
        return Uint8Array.prototype.indexOf.call(buffer, val, byteOffset)
      } else {
        return Uint8Array.prototype.lastIndexOf.call(buffer, val, byteOffset)
      }
    }
    return arrayIndexOf(buffer, [ val ], byteOffset, encoding, dir)
  }

  throw new TypeError('val must be string, number or Buffer')
}

function arrayIndexOf (arr, val, byteOffset, encoding, dir) {
  var indexSize = 1
  var arrLength = arr.length
  var valLength = val.length

  if (encoding !== undefined) {
    encoding = String(encoding).toLowerCase()
    if (encoding === 'ucs2' || encoding === 'ucs-2' ||
        encoding === 'utf16le' || encoding === 'utf-16le') {
      if (arr.length < 2 || val.length < 2) {
        return -1
      }
      indexSize = 2
      arrLength /= 2
      valLength /= 2
      byteOffset /= 2
    }
  }

  function read (buf, i) {
    if (indexSize === 1) {
      return buf[i]
    } else {
      return buf.readUInt16BE(i * indexSize)
    }
  }

  var i
  if (dir) {
    var foundIndex = -1
    for (i = byteOffset; i < arrLength; i++) {
      if (read(arr, i) === read(val, foundIndex === -1 ? 0 : i - foundIndex)) {
        if (foundIndex === -1) foundIndex = i
        if (i - foundIndex + 1 === valLength) return foundIndex * indexSize
      } else {
        if (foundIndex !== -1) i -= i - foundIndex
        foundIndex = -1
      }
    }
  } else {
    if (byteOffset + valLength > arrLength) byteOffset = arrLength - valLength
    for (i = byteOffset; i >= 0; i--) {
      var found = true
      for (var j = 0; j < valLength; j++) {
        if (read(arr, i + j) !== read(val, j)) {
          found = false
          break
        }
      }
      if (found) return i
    }
  }

  return -1
}

Buffer.prototype.includes = function includes (val, byteOffset, encoding) {
  return this.indexOf(val, byteOffset, encoding) !== -1
}

Buffer.prototype.indexOf = function indexOf (val, byteOffset, encoding) {
  return bidirectionalIndexOf(this, val, byteOffset, encoding, true)
}

Buffer.prototype.lastIndexOf = function lastIndexOf (val, byteOffset, encoding) {
  return bidirectionalIndexOf(this, val, byteOffset, encoding, false)
}

function hexWrite (buf, string, offset, length) {
  offset = Number(offset) || 0
  var remaining = buf.length - offset
  if (!length) {
    length = remaining
  } else {
    length = Number(length)
    if (length > remaining) {
      length = remaining
    }
  }

  // must be an even number of digits
  var strLen = string.length
  if (strLen % 2 !== 0) throw new TypeError('Invalid hex string')

  if (length > strLen / 2) {
    length = strLen / 2
  }
  for (var i = 0; i < length; ++i) {
    var parsed = parseInt(string.substr(i * 2, 2), 16)
    if (isNaN(parsed)) return i
    buf[offset + i] = parsed
  }
  return i
}

function utf8Write (buf, string, offset, length) {
  return blitBuffer(utf8ToBytes(string, buf.length - offset), buf, offset, length)
}

function asciiWrite (buf, string, offset, length) {
  return blitBuffer(asciiToBytes(string), buf, offset, length)
}

function latin1Write (buf, string, offset, length) {
  return asciiWrite(buf, string, offset, length)
}

function base64Write (buf, string, offset, length) {
  return blitBuffer(base64ToBytes(string), buf, offset, length)
}

function ucs2Write (buf, string, offset, length) {
  return blitBuffer(utf16leToBytes(string, buf.length - offset), buf, offset, length)
}

Buffer.prototype.write = function write (string, offset, length, encoding) {
  // Buffer#write(string)
  if (offset === undefined) {
    encoding = 'utf8'
    length = this.length
    offset = 0
  // Buffer#write(string, encoding)
  } else if (length === undefined && typeof offset === 'string') {
    encoding = offset
    length = this.length
    offset = 0
  // Buffer#write(string, offset[, length][, encoding])
  } else if (isFinite(offset)) {
    offset = offset | 0
    if (isFinite(length)) {
      length = length | 0
      if (encoding === undefined) encoding = 'utf8'
    } else {
      encoding = length
      length = undefined
    }
  // legacy write(string, encoding, offset, length) - remove in v0.13
  } else {
    throw new Error(
      'Buffer.write(string, encoding, offset[, length]) is no longer supported'
    )
  }

  var remaining = this.length - offset
  if (length === undefined || length > remaining) length = remaining

  if ((string.length > 0 && (length < 0 || offset < 0)) || offset > this.length) {
    throw new RangeError('Attempt to write outside buffer bounds')
  }

  if (!encoding) encoding = 'utf8'

  var loweredCase = false
  for (;;) {
    switch (encoding) {
      case 'hex':
        return hexWrite(this, string, offset, length)

      case 'utf8':
      case 'utf-8':
        return utf8Write(this, string, offset, length)

      case 'ascii':
        return asciiWrite(this, string, offset, length)

      case 'latin1':
      case 'binary':
        return latin1Write(this, string, offset, length)

      case 'base64':
        // Warning: maxLength not taken into account in base64Write
        return base64Write(this, string, offset, length)

      case 'ucs2':
      case 'ucs-2':
      case 'utf16le':
      case 'utf-16le':
        return ucs2Write(this, string, offset, length)

      default:
        if (loweredCase) throw new TypeError('Unknown encoding: ' + encoding)
        encoding = ('' + encoding).toLowerCase()
        loweredCase = true
    }
  }
}

Buffer.prototype.toJSON = function toJSON () {
  return {
    type: 'Buffer',
    data: Array.prototype.slice.call(this._arr || this, 0)
  }
}

function base64Slice (buf, start, end) {
  if (start === 0 && end === buf.length) {
    return base64.fromByteArray(buf)
  } else {
    return base64.fromByteArray(buf.slice(start, end))
  }
}

function utf8Slice (buf, start, end) {
  end = Math.min(buf.length, end)
  var res = []

  var i = start
  while (i < end) {
    var firstByte = buf[i]
    var codePoint = null
    var bytesPerSequence = (firstByte > 0xEF) ? 4
      : (firstByte > 0xDF) ? 3
      : (firstByte > 0xBF) ? 2
      : 1

    if (i + bytesPerSequence <= end) {
      var secondByte, thirdByte, fourthByte, tempCodePoint

      switch (bytesPerSequence) {
        case 1:
          if (firstByte < 0x80) {
            codePoint = firstByte
          }
          break
        case 2:
          secondByte = buf[i + 1]
          if ((secondByte & 0xC0) === 0x80) {
            tempCodePoint = (firstByte & 0x1F) << 0x6 | (secondByte & 0x3F)
            if (tempCodePoint > 0x7F) {
              codePoint = tempCodePoint
            }
          }
          break
        case 3:
          secondByte = buf[i + 1]
          thirdByte = buf[i + 2]
          if ((secondByte & 0xC0) === 0x80 && (thirdByte & 0xC0) === 0x80) {
            tempCodePoint = (firstByte & 0xF) << 0xC | (secondByte & 0x3F) << 0x6 | (thirdByte & 0x3F)
            if (tempCodePoint > 0x7FF && (tempCodePoint < 0xD800 || tempCodePoint > 0xDFFF)) {
              codePoint = tempCodePoint
            }
          }
          break
        case 4:
          secondByte = buf[i + 1]
          thirdByte = buf[i + 2]
          fourthByte = buf[i + 3]
          if ((secondByte & 0xC0) === 0x80 && (thirdByte & 0xC0) === 0x80 && (fourthByte & 0xC0) === 0x80) {
            tempCodePoint = (firstByte & 0xF) << 0x12 | (secondByte & 0x3F) << 0xC | (thirdByte & 0x3F) << 0x6 | (fourthByte & 0x3F)
            if (tempCodePoint > 0xFFFF && tempCodePoint < 0x110000) {
              codePoint = tempCodePoint
            }
          }
      }
    }

    if (codePoint === null) {
      // we did not generate a valid codePoint so insert a
      // replacement char (U+FFFD) and advance only 1 byte
      codePoint = 0xFFFD
      bytesPerSequence = 1
    } else if (codePoint > 0xFFFF) {
      // encode to utf16 (surrogate pair dance)
      codePoint -= 0x10000
      res.push(codePoint >>> 10 & 0x3FF | 0xD800)
      codePoint = 0xDC00 | codePoint & 0x3FF
    }

    res.push(codePoint)
    i += bytesPerSequence
  }

  return decodeCodePointsArray(res)
}

// Based on http://stackoverflow.com/a/22747272/680742, the browser with
// the lowest limit is Chrome, with 0x10000 args.
// We go 1 magnitude less, for safety
var MAX_ARGUMENTS_LENGTH = 0x1000

function decodeCodePointsArray (codePoints) {
  var len = codePoints.length
  if (len <= MAX_ARGUMENTS_LENGTH) {
    return String.fromCharCode.apply(String, codePoints) // avoid extra slice()
  }

  // Decode in chunks to avoid "call stack size exceeded".
  var res = ''
  var i = 0
  while (i < len) {
    res += String.fromCharCode.apply(
      String,
      codePoints.slice(i, i += MAX_ARGUMENTS_LENGTH)
    )
  }
  return res
}

function asciiSlice (buf, start, end) {
  var ret = ''
  end = Math.min(buf.length, end)

  for (var i = start; i < end; ++i) {
    ret += String.fromCharCode(buf[i] & 0x7F)
  }
  return ret
}

function latin1Slice (buf, start, end) {
  var ret = ''
  end = Math.min(buf.length, end)

  for (var i = start; i < end; ++i) {
    ret += String.fromCharCode(buf[i])
  }
  return ret
}

function hexSlice (buf, start, end) {
  var len = buf.length

  if (!start || start < 0) start = 0
  if (!end || end < 0 || end > len) end = len

  var out = ''
  for (var i = start; i < end; ++i) {
    out += toHex(buf[i])
  }
  return out
}

function utf16leSlice (buf, start, end) {
  var bytes = buf.slice(start, end)
  var res = ''
  for (var i = 0; i < bytes.length; i += 2) {
    res += String.fromCharCode(bytes[i] + bytes[i + 1] * 256)
  }
  return res
}

Buffer.prototype.slice = function slice (start, end) {
  var len = this.length
  start = ~~start
  end = end === undefined ? len : ~~end

  if (start < 0) {
    start += len
    if (start < 0) start = 0
  } else if (start > len) {
    start = len
  }

  if (end < 0) {
    end += len
    if (end < 0) end = 0
  } else if (end > len) {
    end = len
  }

  if (end < start) end = start

  var newBuf
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    newBuf = this.subarray(start, end)
    newBuf.__proto__ = Buffer.prototype
  } else {
    var sliceLen = end - start
    newBuf = new Buffer(sliceLen, undefined)
    for (var i = 0; i < sliceLen; ++i) {
      newBuf[i] = this[i + start]
    }
  }

  return newBuf
}

/*
 * Need to make sure that buffer isn't trying to write out of bounds.
 */
function checkOffset (offset, ext, length) {
  if ((offset % 1) !== 0 || offset < 0) throw new RangeError('offset is not uint')
  if (offset + ext > length) throw new RangeError('Trying to access beyond buffer length')
}

Buffer.prototype.readUIntLE = function readUIntLE (offset, byteLength, noAssert) {
  offset = offset | 0
  byteLength = byteLength | 0
  if (!noAssert) checkOffset(offset, byteLength, this.length)

  var val = this[offset]
  var mul = 1
  var i = 0
  while (++i < byteLength && (mul *= 0x100)) {
    val += this[offset + i] * mul
  }

  return val
}

Buffer.prototype.readUIntBE = function readUIntBE (offset, byteLength, noAssert) {
  offset = offset | 0
  byteLength = byteLength | 0
  if (!noAssert) {
    checkOffset(offset, byteLength, this.length)
  }

  var val = this[offset + --byteLength]
  var mul = 1
  while (byteLength > 0 && (mul *= 0x100)) {
    val += this[offset + --byteLength] * mul
  }

  return val
}

Buffer.prototype.readUInt8 = function readUInt8 (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 1, this.length)
  return this[offset]
}

Buffer.prototype.readUInt16LE = function readUInt16LE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 2, this.length)
  return this[offset] | (this[offset + 1] << 8)
}

Buffer.prototype.readUInt16BE = function readUInt16BE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 2, this.length)
  return (this[offset] << 8) | this[offset + 1]
}

Buffer.prototype.readUInt32LE = function readUInt32LE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 4, this.length)

  return ((this[offset]) |
      (this[offset + 1] << 8) |
      (this[offset + 2] << 16)) +
      (this[offset + 3] * 0x1000000)
}

Buffer.prototype.readUInt32BE = function readUInt32BE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 4, this.length)

  return (this[offset] * 0x1000000) +
    ((this[offset + 1] << 16) |
    (this[offset + 2] << 8) |
    this[offset + 3])
}

Buffer.prototype.readIntLE = function readIntLE (offset, byteLength, noAssert) {
  offset = offset | 0
  byteLength = byteLength | 0
  if (!noAssert) checkOffset(offset, byteLength, this.length)

  var val = this[offset]
  var mul = 1
  var i = 0
  while (++i < byteLength && (mul *= 0x100)) {
    val += this[offset + i] * mul
  }
  mul *= 0x80

  if (val >= mul) val -= Math.pow(2, 8 * byteLength)

  return val
}

Buffer.prototype.readIntBE = function readIntBE (offset, byteLength, noAssert) {
  offset = offset | 0
  byteLength = byteLength | 0
  if (!noAssert) checkOffset(offset, byteLength, this.length)

  var i = byteLength
  var mul = 1
  var val = this[offset + --i]
  while (i > 0 && (mul *= 0x100)) {
    val += this[offset + --i] * mul
  }
  mul *= 0x80

  if (val >= mul) val -= Math.pow(2, 8 * byteLength)

  return val
}

Buffer.prototype.readInt8 = function readInt8 (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 1, this.length)
  if (!(this[offset] & 0x80)) return (this[offset])
  return ((0xff - this[offset] + 1) * -1)
}

Buffer.prototype.readInt16LE = function readInt16LE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 2, this.length)
  var val = this[offset] | (this[offset + 1] << 8)
  return (val & 0x8000) ? val | 0xFFFF0000 : val
}

Buffer.prototype.readInt16BE = function readInt16BE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 2, this.length)
  var val = this[offset + 1] | (this[offset] << 8)
  return (val & 0x8000) ? val | 0xFFFF0000 : val
}

Buffer.prototype.readInt32LE = function readInt32LE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 4, this.length)

  return (this[offset]) |
    (this[offset + 1] << 8) |
    (this[offset + 2] << 16) |
    (this[offset + 3] << 24)
}

Buffer.prototype.readInt32BE = function readInt32BE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 4, this.length)

  return (this[offset] << 24) |
    (this[offset + 1] << 16) |
    (this[offset + 2] << 8) |
    (this[offset + 3])
}

Buffer.prototype.readFloatLE = function readFloatLE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 4, this.length)
  return ieee754.read(this, offset, true, 23, 4)
}

Buffer.prototype.readFloatBE = function readFloatBE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 4, this.length)
  return ieee754.read(this, offset, false, 23, 4)
}

Buffer.prototype.readDoubleLE = function readDoubleLE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 8, this.length)
  return ieee754.read(this, offset, true, 52, 8)
}

Buffer.prototype.readDoubleBE = function readDoubleBE (offset, noAssert) {
  if (!noAssert) checkOffset(offset, 8, this.length)
  return ieee754.read(this, offset, false, 52, 8)
}

function checkInt (buf, value, offset, ext, max, min) {
  if (!Buffer.isBuffer(buf)) throw new TypeError('"buffer" argument must be a Buffer instance')
  if (value > max || value < min) throw new RangeError('"value" argument is out of bounds')
  if (offset + ext > buf.length) throw new RangeError('Index out of range')
}

Buffer.prototype.writeUIntLE = function writeUIntLE (value, offset, byteLength, noAssert) {
  value = +value
  offset = offset | 0
  byteLength = byteLength | 0
  if (!noAssert) {
    var maxBytes = Math.pow(2, 8 * byteLength) - 1
    checkInt(this, value, offset, byteLength, maxBytes, 0)
  }

  var mul = 1
  var i = 0
  this[offset] = value & 0xFF
  while (++i < byteLength && (mul *= 0x100)) {
    this[offset + i] = (value / mul) & 0xFF
  }

  return offset + byteLength
}

Buffer.prototype.writeUIntBE = function writeUIntBE (value, offset, byteLength, noAssert) {
  value = +value
  offset = offset | 0
  byteLength = byteLength | 0
  if (!noAssert) {
    var maxBytes = Math.pow(2, 8 * byteLength) - 1
    checkInt(this, value, offset, byteLength, maxBytes, 0)
  }

  var i = byteLength - 1
  var mul = 1
  this[offset + i] = value & 0xFF
  while (--i >= 0 && (mul *= 0x100)) {
    this[offset + i] = (value / mul) & 0xFF
  }

  return offset + byteLength
}

Buffer.prototype.writeUInt8 = function writeUInt8 (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 1, 0xff, 0)
  if (!Buffer.TYPED_ARRAY_SUPPORT) value = Math.floor(value)
  this[offset] = (value & 0xff)
  return offset + 1
}

function objectWriteUInt16 (buf, value, offset, littleEndian) {
  if (value < 0) value = 0xffff + value + 1
  for (var i = 0, j = Math.min(buf.length - offset, 2); i < j; ++i) {
    buf[offset + i] = (value & (0xff << (8 * (littleEndian ? i : 1 - i)))) >>>
      (littleEndian ? i : 1 - i) * 8
  }
}

Buffer.prototype.writeUInt16LE = function writeUInt16LE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 2, 0xffff, 0)
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset] = (value & 0xff)
    this[offset + 1] = (value >>> 8)
  } else {
    objectWriteUInt16(this, value, offset, true)
  }
  return offset + 2
}

Buffer.prototype.writeUInt16BE = function writeUInt16BE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 2, 0xffff, 0)
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset] = (value >>> 8)
    this[offset + 1] = (value & 0xff)
  } else {
    objectWriteUInt16(this, value, offset, false)
  }
  return offset + 2
}

function objectWriteUInt32 (buf, value, offset, littleEndian) {
  if (value < 0) value = 0xffffffff + value + 1
  for (var i = 0, j = Math.min(buf.length - offset, 4); i < j; ++i) {
    buf[offset + i] = (value >>> (littleEndian ? i : 3 - i) * 8) & 0xff
  }
}

Buffer.prototype.writeUInt32LE = function writeUInt32LE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 4, 0xffffffff, 0)
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset + 3] = (value >>> 24)
    this[offset + 2] = (value >>> 16)
    this[offset + 1] = (value >>> 8)
    this[offset] = (value & 0xff)
  } else {
    objectWriteUInt32(this, value, offset, true)
  }
  return offset + 4
}

Buffer.prototype.writeUInt32BE = function writeUInt32BE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 4, 0xffffffff, 0)
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset] = (value >>> 24)
    this[offset + 1] = (value >>> 16)
    this[offset + 2] = (value >>> 8)
    this[offset + 3] = (value & 0xff)
  } else {
    objectWriteUInt32(this, value, offset, false)
  }
  return offset + 4
}

Buffer.prototype.writeIntLE = function writeIntLE (value, offset, byteLength, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) {
    var limit = Math.pow(2, 8 * byteLength - 1)

    checkInt(this, value, offset, byteLength, limit - 1, -limit)
  }

  var i = 0
  var mul = 1
  var sub = 0
  this[offset] = value & 0xFF
  while (++i < byteLength && (mul *= 0x100)) {
    if (value < 0 && sub === 0 && this[offset + i - 1] !== 0) {
      sub = 1
    }
    this[offset + i] = ((value / mul) >> 0) - sub & 0xFF
  }

  return offset + byteLength
}

Buffer.prototype.writeIntBE = function writeIntBE (value, offset, byteLength, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) {
    var limit = Math.pow(2, 8 * byteLength - 1)

    checkInt(this, value, offset, byteLength, limit - 1, -limit)
  }

  var i = byteLength - 1
  var mul = 1
  var sub = 0
  this[offset + i] = value & 0xFF
  while (--i >= 0 && (mul *= 0x100)) {
    if (value < 0 && sub === 0 && this[offset + i + 1] !== 0) {
      sub = 1
    }
    this[offset + i] = ((value / mul) >> 0) - sub & 0xFF
  }

  return offset + byteLength
}

Buffer.prototype.writeInt8 = function writeInt8 (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 1, 0x7f, -0x80)
  if (!Buffer.TYPED_ARRAY_SUPPORT) value = Math.floor(value)
  if (value < 0) value = 0xff + value + 1
  this[offset] = (value & 0xff)
  return offset + 1
}

Buffer.prototype.writeInt16LE = function writeInt16LE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 2, 0x7fff, -0x8000)
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset] = (value & 0xff)
    this[offset + 1] = (value >>> 8)
  } else {
    objectWriteUInt16(this, value, offset, true)
  }
  return offset + 2
}

Buffer.prototype.writeInt16BE = function writeInt16BE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 2, 0x7fff, -0x8000)
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset] = (value >>> 8)
    this[offset + 1] = (value & 0xff)
  } else {
    objectWriteUInt16(this, value, offset, false)
  }
  return offset + 2
}

Buffer.prototype.writeInt32LE = function writeInt32LE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 4, 0x7fffffff, -0x80000000)
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset] = (value & 0xff)
    this[offset + 1] = (value >>> 8)
    this[offset + 2] = (value >>> 16)
    this[offset + 3] = (value >>> 24)
  } else {
    objectWriteUInt32(this, value, offset, true)
  }
  return offset + 4
}

Buffer.prototype.writeInt32BE = function writeInt32BE (value, offset, noAssert) {
  value = +value
  offset = offset | 0
  if (!noAssert) checkInt(this, value, offset, 4, 0x7fffffff, -0x80000000)
  if (value < 0) value = 0xffffffff + value + 1
  if (Buffer.TYPED_ARRAY_SUPPORT) {
    this[offset] = (value >>> 24)
    this[offset + 1] = (value >>> 16)
    this[offset + 2] = (value >>> 8)
    this[offset + 3] = (value & 0xff)
  } else {
    objectWriteUInt32(this, value, offset, false)
  }
  return offset + 4
}

function checkIEEE754 (buf, value, offset, ext, max, min) {
  if (offset + ext > buf.length) throw new RangeError('Index out of range')
  if (offset < 0) throw new RangeError('Index out of range')
}

function writeFloat (buf, value, offset, littleEndian, noAssert) {
  if (!noAssert) {
    checkIEEE754(buf, value, offset, 4, 3.4028234663852886e+38, -3.4028234663852886e+38)
  }
  ieee754.write(buf, value, offset, littleEndian, 23, 4)
  return offset + 4
}

Buffer.prototype.writeFloatLE = function writeFloatLE (value, offset, noAssert) {
  return writeFloat(this, value, offset, true, noAssert)
}

Buffer.prototype.writeFloatBE = function writeFloatBE (value, offset, noAssert) {
  return writeFloat(this, value, offset, false, noAssert)
}

function writeDouble (buf, value, offset, littleEndian, noAssert) {
  if (!noAssert) {
    checkIEEE754(buf, value, offset, 8, 1.7976931348623157E+308, -1.7976931348623157E+308)
  }
  ieee754.write(buf, value, offset, littleEndian, 52, 8)
  return offset + 8
}

Buffer.prototype.writeDoubleLE = function writeDoubleLE (value, offset, noAssert) {
  return writeDouble(this, value, offset, true, noAssert)
}

Buffer.prototype.writeDoubleBE = function writeDoubleBE (value, offset, noAssert) {
  return writeDouble(this, value, offset, false, noAssert)
}

// copy(targetBuffer, targetStart=0, sourceStart=0, sourceEnd=buffer.length)
Buffer.prototype.copy = function copy (target, targetStart, start, end) {
  if (!start) start = 0
  if (!end && end !== 0) end = this.length
  if (targetStart >= target.length) targetStart = target.length
  if (!targetStart) targetStart = 0
  if (end > 0 && end < start) end = start

  // Copy 0 bytes; we're done
  if (end === start) return 0
  if (target.length === 0 || this.length === 0) return 0

  // Fatal error conditions
  if (targetStart < 0) {
    throw new RangeError('targetStart out of bounds')
  }
  if (start < 0 || start >= this.length) throw new RangeError('sourceStart out of bounds')
  if (end < 0) throw new RangeError('sourceEnd out of bounds')

  // Are we oob?
  if (end > this.length) end = this.length
  if (target.length - targetStart < end - start) {
    end = target.length - targetStart + start
  }

  var len = end - start
  var i

  if (this === target && start < targetStart && targetStart < end) {
    // descending copy from end
    for (i = len - 1; i >= 0; --i) {
      target[i + targetStart] = this[i + start]
    }
  } else if (len < 1000 || !Buffer.TYPED_ARRAY_SUPPORT) {
    // ascending copy from start
    for (i = 0; i < len; ++i) {
      target[i + targetStart] = this[i + start]
    }
  } else {
    Uint8Array.prototype.set.call(
      target,
      this.subarray(start, start + len),
      targetStart
    )
  }

  return len
}

// Usage:
//    buffer.fill(number[, offset[, end]])
//    buffer.fill(buffer[, offset[, end]])
//    buffer.fill(string[, offset[, end]][, encoding])
Buffer.prototype.fill = function fill (val, start, end, encoding) {
  // Handle string cases:
  if (typeof val === 'string') {
    if (typeof start === 'string') {
      encoding = start
      start = 0
      end = this.length
    } else if (typeof end === 'string') {
      encoding = end
      end = this.length
    }
    if (val.length === 1) {
      var code = val.charCodeAt(0)
      if (code < 256) {
        val = code
      }
    }
    if (encoding !== undefined && typeof encoding !== 'string') {
      throw new TypeError('encoding must be a string')
    }
    if (typeof encoding === 'string' && !Buffer.isEncoding(encoding)) {
      throw new TypeError('Unknown encoding: ' + encoding)
    }
  } else if (typeof val === 'number') {
    val = val & 255
  }

  // Invalid ranges are not set to a default, so can range check early.
  if (start < 0 || this.length < start || this.length < end) {
    throw new RangeError('Out of range index')
  }

  if (end <= start) {
    return this
  }

  start = start >>> 0
  end = end === undefined ? this.length : end >>> 0

  if (!val) val = 0

  var i
  if (typeof val === 'number') {
    for (i = start; i < end; ++i) {
      this[i] = val
    }
  } else {
    var bytes = Buffer.isBuffer(val)
      ? val
      : utf8ToBytes(new Buffer(val, encoding).toString())
    var len = bytes.length
    for (i = 0; i < end - start; ++i) {
      this[i + start] = bytes[i % len]
    }
  }

  return this
}

// HELPER FUNCTIONS
// ================

var INVALID_BASE64_RE = /[^+\/0-9A-Za-z-_]/g

function base64clean (str) {
  // Node strips out invalid characters like \n and \t from the string, base64-js does not
  str = stringtrim(str).replace(INVALID_BASE64_RE, '')
  // Node converts strings with length < 2 to ''
  if (str.length < 2) return ''
  // Node allows for non-padded base64 strings (missing trailing ===), base64-js does not
  while (str.length % 4 !== 0) {
    str = str + '='
  }
  return str
}

function stringtrim (str) {
  if (str.trim) return str.trim()
  return str.replace(/^\s+|\s+$/g, '')
}

function toHex (n) {
  if (n < 16) return '0' + n.toString(16)
  return n.toString(16)
}

function utf8ToBytes (string, units) {
  units = units || Infinity
  var codePoint
  var length = string.length
  var leadSurrogate = null
  var bytes = []

  for (var i = 0; i < length; ++i) {
    codePoint = string.charCodeAt(i)

    // is surrogate component
    if (codePoint > 0xD7FF && codePoint < 0xE000) {
      // last char was a lead
      if (!leadSurrogate) {
        // no lead yet
        if (codePoint > 0xDBFF) {
          // unexpected trail
          if ((units -= 3) > -1) bytes.push(0xEF, 0xBF, 0xBD)
          continue
        } else if (i + 1 === length) {
          // unpaired lead
          if ((units -= 3) > -1) bytes.push(0xEF, 0xBF, 0xBD)
          continue
        }

        // valid lead
        leadSurrogate = codePoint

        continue
      }

      // 2 leads in a row
      if (codePoint < 0xDC00) {
        if ((units -= 3) > -1) bytes.push(0xEF, 0xBF, 0xBD)
        leadSurrogate = codePoint
        continue
      }

      // valid surrogate pair
      codePoint = (leadSurrogate - 0xD800 << 10 | codePoint - 0xDC00) + 0x10000
    } else if (leadSurrogate) {
      // valid bmp char, but last char was a lead
      if ((units -= 3) > -1) bytes.push(0xEF, 0xBF, 0xBD)
    }

    leadSurrogate = null

    // encode utf8
    if (codePoint < 0x80) {
      if ((units -= 1) < 0) break
      bytes.push(codePoint)
    } else if (codePoint < 0x800) {
      if ((units -= 2) < 0) break
      bytes.push(
        codePoint >> 0x6 | 0xC0,
        codePoint & 0x3F | 0x80
      )
    } else if (codePoint < 0x10000) {
      if ((units -= 3) < 0) break
      bytes.push(
        codePoint >> 0xC | 0xE0,
        codePoint >> 0x6 & 0x3F | 0x80,
        codePoint & 0x3F | 0x80
      )
    } else if (codePoint < 0x110000) {
      if ((units -= 4) < 0) break
      bytes.push(
        codePoint >> 0x12 | 0xF0,
        codePoint >> 0xC & 0x3F | 0x80,
        codePoint >> 0x6 & 0x3F | 0x80,
        codePoint & 0x3F | 0x80
      )
    } else {
      throw new Error('Invalid code point')
    }
  }

  return bytes
}

function asciiToBytes (str) {
  var byteArray = []
  for (var i = 0; i < str.length; ++i) {
    // Node's code seems to be doing this and not & 0x7F..
    byteArray.push(str.charCodeAt(i) & 0xFF)
  }
  return byteArray
}

function utf16leToBytes (str, units) {
  var c, hi, lo
  var byteArray = []
  for (var i = 0; i < str.length; ++i) {
    if ((units -= 2) < 0) break

    c = str.charCodeAt(i)
    hi = c >> 8
    lo = c % 256
    byteArray.push(lo)
    byteArray.push(hi)
  }

  return byteArray
}

function base64ToBytes (str) {
  return base64.toByteArray(base64clean(str))
}

function blitBuffer (src, dst, offset, length) {
  for (var i = 0; i < length; ++i) {
    if ((i + offset >= dst.length) || (i >= src.length)) break
    dst[i + offset] = src[i]
  }
  return i
}

function isnan (val) {
  return val !== val // eslint-disable-line no-self-compare
}


/***/ }),

/***/ "./node_modules/ieee754/index.js":
/*!***************************************!*\
  !*** ./node_modules/ieee754/index.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, exports) => {

/*! ieee754. BSD-3-Clause License. Feross Aboukhadijeh <https://feross.org/opensource> */
exports.read = function (buffer, offset, isLE, mLen, nBytes) {
  var e, m
  var eLen = (nBytes * 8) - mLen - 1
  var eMax = (1 << eLen) - 1
  var eBias = eMax >> 1
  var nBits = -7
  var i = isLE ? (nBytes - 1) : 0
  var d = isLE ? -1 : 1
  var s = buffer[offset + i]

  i += d

  e = s & ((1 << (-nBits)) - 1)
  s >>= (-nBits)
  nBits += eLen
  for (; nBits > 0; e = (e * 256) + buffer[offset + i], i += d, nBits -= 8) {}

  m = e & ((1 << (-nBits)) - 1)
  e >>= (-nBits)
  nBits += mLen
  for (; nBits > 0; m = (m * 256) + buffer[offset + i], i += d, nBits -= 8) {}

  if (e === 0) {
    e = 1 - eBias
  } else if (e === eMax) {
    return m ? NaN : ((s ? -1 : 1) * Infinity)
  } else {
    m = m + Math.pow(2, mLen)
    e = e - eBias
  }
  return (s ? -1 : 1) * m * Math.pow(2, e - mLen)
}

exports.write = function (buffer, value, offset, isLE, mLen, nBytes) {
  var e, m, c
  var eLen = (nBytes * 8) - mLen - 1
  var eMax = (1 << eLen) - 1
  var eBias = eMax >> 1
  var rt = (mLen === 23 ? Math.pow(2, -24) - Math.pow(2, -77) : 0)
  var i = isLE ? 0 : (nBytes - 1)
  var d = isLE ? 1 : -1
  var s = value < 0 || (value === 0 && 1 / value < 0) ? 1 : 0

  value = Math.abs(value)

  if (isNaN(value) || value === Infinity) {
    m = isNaN(value) ? 1 : 0
    e = eMax
  } else {
    e = Math.floor(Math.log(value) / Math.LN2)
    if (value * (c = Math.pow(2, -e)) < 1) {
      e--
      c *= 2
    }
    if (e + eBias >= 1) {
      value += rt / c
    } else {
      value += rt * Math.pow(2, 1 - eBias)
    }
    if (value * c >= 2) {
      e++
      c /= 2
    }

    if (e + eBias >= eMax) {
      m = 0
      e = eMax
    } else if (e + eBias >= 1) {
      m = ((value * c) - 1) * Math.pow(2, mLen)
      e = e + eBias
    } else {
      m = value * Math.pow(2, eBias - 1) * Math.pow(2, mLen)
      e = 0
    }
  }

  for (; mLen >= 8; buffer[offset + i] = m & 0xff, i += d, m /= 256, mLen -= 8) {}

  e = (e << mLen) | m
  eLen += mLen
  for (; eLen > 0; buffer[offset + i] = e & 0xff, i += d, e /= 256, eLen -= 8) {}

  buffer[offset + i - d] |= s * 128
}


/***/ }),

/***/ "./node_modules/isarray/index.js":
/*!***************************************!*\
  !*** ./node_modules/isarray/index.js ***!
  \***************************************/
/***/ ((module) => {

var toString = {}.toString;

module.exports = Array.isArray || function (arr) {
  return toString.call(arr) == '[object Array]';
};


/***/ }),

/***/ "./node_modules/qr-code-styling/lib/qr-code-styling.js":
/*!*************************************************************!*\
  !*** ./node_modules/qr-code-styling/lib/qr-code-styling.js ***!
  \*************************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

/* provided dependency */ var Buffer = __webpack_require__(/*! buffer */ "./node_modules/buffer/index.js")["Buffer"];
!function(t,e){ true?module.exports=e():0}(this,(()=>(()=>{var t={873:(t,e)=>{var i,r,n=function(){var t=function(t,e){var i=t,r=s[e],n=null,o=0,h=null,p=[],v={},m=function(t,e){n=function(t){for(var e=new Array(t),i=0;i<t;i+=1){e[i]=new Array(t);for(var r=0;r<t;r+=1)e[i][r]=null}return e}(o=4*i+17),b(0,0),b(o-7,0),b(0,o-7),x(),y(),C(t,e),i>=7&&S(t),null==h&&(h=M(i,r,p)),A(h,e)},b=function(t,e){for(var i=-1;i<=7;i+=1)if(!(t+i<=-1||o<=t+i))for(var r=-1;r<=7;r+=1)e+r<=-1||o<=e+r||(n[t+i][e+r]=0<=i&&i<=6&&(0==r||6==r)||0<=r&&r<=6&&(0==i||6==i)||2<=i&&i<=4&&2<=r&&r<=4)},y=function(){for(var t=8;t<o-8;t+=1)null==n[t][6]&&(n[t][6]=t%2==0);for(var e=8;e<o-8;e+=1)null==n[6][e]&&(n[6][e]=e%2==0)},x=function(){for(var t=a.getPatternPosition(i),e=0;e<t.length;e+=1)for(var r=0;r<t.length;r+=1){var o=t[e],s=t[r];if(null==n[o][s])for(var h=-2;h<=2;h+=1)for(var d=-2;d<=2;d+=1)n[o+h][s+d]=-2==h||2==h||-2==d||2==d||0==h&&0==d}},S=function(t){for(var e=a.getBCHTypeNumber(i),r=0;r<18;r+=1){var s=!t&&1==(e>>r&1);n[Math.floor(r/3)][r%3+o-8-3]=s}for(r=0;r<18;r+=1)s=!t&&1==(e>>r&1),n[r%3+o-8-3][Math.floor(r/3)]=s},C=function(t,e){for(var i=r<<3|e,s=a.getBCHTypeInfo(i),h=0;h<15;h+=1){var d=!t&&1==(s>>h&1);h<6?n[h][8]=d:h<8?n[h+1][8]=d:n[o-15+h][8]=d}for(h=0;h<15;h+=1)d=!t&&1==(s>>h&1),h<8?n[8][o-h-1]=d:h<9?n[8][15-h-1+1]=d:n[8][15-h-1]=d;n[o-8][8]=!t},A=function(t,e){for(var i=-1,r=o-1,s=7,h=0,d=a.getMaskFunction(e),u=o-1;u>0;u-=2)for(6==u&&(u-=1);;){for(var c=0;c<2;c+=1)if(null==n[r][u-c]){var l=!1;h<t.length&&(l=1==(t[h]>>>s&1)),d(r,u-c)&&(l=!l),n[r][u-c]=l,-1==(s-=1)&&(h+=1,s=7)}if((r+=i)<0||o<=r){r-=i,i=-i;break}}},M=function(t,e,i){for(var r=u.getRSBlocks(t,e),n=c(),o=0;o<i.length;o+=1){var s=i[o];n.put(s.getMode(),4),n.put(s.getLength(),a.getLengthInBits(s.getMode(),t)),s.write(n)}var h=0;for(o=0;o<r.length;o+=1)h+=r[o].dataCount;if(n.getLengthInBits()>8*h)throw"code length overflow. ("+n.getLengthInBits()+">"+8*h+")";for(n.getLengthInBits()+4<=8*h&&n.put(0,4);n.getLengthInBits()%8!=0;)n.putBit(!1);for(;!(n.getLengthInBits()>=8*h||(n.put(236,8),n.getLengthInBits()>=8*h));)n.put(17,8);return function(t,e){for(var i=0,r=0,n=0,o=new Array(e.length),s=new Array(e.length),h=0;h<e.length;h+=1){var u=e[h].dataCount,c=e[h].totalCount-u;r=Math.max(r,u),n=Math.max(n,c),o[h]=new Array(u);for(var l=0;l<o[h].length;l+=1)o[h][l]=255&t.getBuffer()[l+i];i+=u;var g=a.getErrorCorrectPolynomial(c),f=d(o[h],g.getLength()-1).mod(g);for(s[h]=new Array(g.getLength()-1),l=0;l<s[h].length;l+=1){var w=l+f.getLength()-s[h].length;s[h][l]=w>=0?f.getAt(w):0}}var p=0;for(l=0;l<e.length;l+=1)p+=e[l].totalCount;var v=new Array(p),_=0;for(l=0;l<r;l+=1)for(h=0;h<e.length;h+=1)l<o[h].length&&(v[_]=o[h][l],_+=1);for(l=0;l<n;l+=1)for(h=0;h<e.length;h+=1)l<s[h].length&&(v[_]=s[h][l],_+=1);return v}(n,r)};v.addData=function(t,e){var i=null;switch(e=e||"Byte"){case"Numeric":i=l(t);break;case"Alphanumeric":i=g(t);break;case"Byte":i=f(t);break;case"Kanji":i=w(t);break;default:throw"mode:"+e}p.push(i),h=null},v.isDark=function(t,e){if(t<0||o<=t||e<0||o<=e)throw t+","+e;return n[t][e]},v.getModuleCount=function(){return o},v.make=function(){if(i<1){for(var t=1;t<40;t++){for(var e=u.getRSBlocks(t,r),n=c(),o=0;o<p.length;o++){var s=p[o];n.put(s.getMode(),4),n.put(s.getLength(),a.getLengthInBits(s.getMode(),t)),s.write(n)}var h=0;for(o=0;o<e.length;o++)h+=e[o].dataCount;if(n.getLengthInBits()<=8*h)break}i=t}m(!1,function(){for(var t=0,e=0,i=0;i<8;i+=1){m(!0,i);var r=a.getLostPoint(v);(0==i||t>r)&&(t=r,e=i)}return e}())},v.createTableTag=function(t,e){t=t||2;var i="";i+='<table style="',i+=" border-width: 0px; border-style: none;",i+=" border-collapse: collapse;",i+=" padding: 0px; margin: "+(e=void 0===e?4*t:e)+"px;",i+='">',i+="<tbody>";for(var r=0;r<v.getModuleCount();r+=1){i+="<tr>";for(var n=0;n<v.getModuleCount();n+=1)i+='<td style="',i+=" border-width: 0px; border-style: none;",i+=" border-collapse: collapse;",i+=" padding: 0px; margin: 0px;",i+=" width: "+t+"px;",i+=" height: "+t+"px;",i+=" background-color: ",i+=v.isDark(r,n)?"#000000":"#ffffff",i+=";",i+='"/>';i+="</tr>"}return(i+="</tbody>")+"</table>"},v.createSvgTag=function(t,e,i,r){var n={};"object"==typeof arguments[0]&&(t=(n=arguments[0]).cellSize,e=n.margin,i=n.alt,r=n.title),t=t||2,e=void 0===e?4*t:e,(i="string"==typeof i?{text:i}:i||{}).text=i.text||null,i.id=i.text?i.id||"qrcode-description":null,(r="string"==typeof r?{text:r}:r||{}).text=r.text||null,r.id=r.text?r.id||"qrcode-title":null;var o,s,a,h,d=v.getModuleCount()*t+2*e,u="";for(h="l"+t+",0 0,"+t+" -"+t+",0 0,-"+t+"z ",u+='<svg version="1.1" xmlns="http://www.w3.org/2000/svg"',u+=n.scalable?"":' width="'+d+'px" height="'+d+'px"',u+=' viewBox="0 0 '+d+" "+d+'" ',u+=' preserveAspectRatio="xMinYMin meet"',u+=r.text||i.text?' role="img" aria-labelledby="'+$([r.id,i.id].join(" ").trim())+'"':"",u+=">",u+=r.text?'<title id="'+$(r.id)+'">'+$(r.text)+"</title>":"",u+=i.text?'<description id="'+$(i.id)+'">'+$(i.text)+"</description>":"",u+='<rect width="100%" height="100%" fill="white" cx="0" cy="0"/>',u+='<path d="',s=0;s<v.getModuleCount();s+=1)for(a=s*t+e,o=0;o<v.getModuleCount();o+=1)v.isDark(s,o)&&(u+="M"+(o*t+e)+","+a+h);return(u+='" stroke="transparent" fill="black"/>')+"</svg>"},v.createDataURL=function(t,e){t=t||2,e=void 0===e?4*t:e;var i=v.getModuleCount()*t+2*e,r=e,n=i-e;return _(i,i,(function(e,i){if(r<=e&&e<n&&r<=i&&i<n){var o=Math.floor((e-r)/t),s=Math.floor((i-r)/t);return v.isDark(s,o)?0:1}return 1}))},v.createImgTag=function(t,e,i){t=t||2,e=void 0===e?4*t:e;var r=v.getModuleCount()*t+2*e,n="";return n+="<img",n+=' src="',n+=v.createDataURL(t,e),n+='"',n+=' width="',n+=r,n+='"',n+=' height="',n+=r,n+='"',i&&(n+=' alt="',n+=$(i),n+='"'),n+"/>"};var $=function(t){for(var e="",i=0;i<t.length;i+=1){var r=t.charAt(i);switch(r){case"<":e+="&lt;";break;case">":e+="&gt;";break;case"&":e+="&amp;";break;case'"':e+="&quot;";break;default:e+=r}}return e};return v.createASCII=function(t,e){if((t=t||1)<2)return function(t){t=void 0===t?2:t;var e,i,r,n,o,s=1*v.getModuleCount()+2*t,a=t,h=s-t,d={"██":"█","█ ":"▀"," █":"▄","  ":" "},u={"██":"▀","█ ":"▀"," █":" ","  ":" "},c="";for(e=0;e<s;e+=2){for(r=Math.floor((e-a)/1),n=Math.floor((e+1-a)/1),i=0;i<s;i+=1)o="█",a<=i&&i<h&&a<=e&&e<h&&v.isDark(r,Math.floor((i-a)/1))&&(o=" "),a<=i&&i<h&&a<=e+1&&e+1<h&&v.isDark(n,Math.floor((i-a)/1))?o+=" ":o+="█",c+=t<1&&e+1>=h?u[o]:d[o];c+="\n"}return s%2&&t>0?c.substring(0,c.length-s-1)+Array(s+1).join("▀"):c.substring(0,c.length-1)}(e);t-=1,e=void 0===e?2*t:e;var i,r,n,o,s=v.getModuleCount()*t+2*e,a=e,h=s-e,d=Array(t+1).join("██"),u=Array(t+1).join("  "),c="",l="";for(i=0;i<s;i+=1){for(n=Math.floor((i-a)/t),l="",r=0;r<s;r+=1)o=1,a<=r&&r<h&&a<=i&&i<h&&v.isDark(n,Math.floor((r-a)/t))&&(o=0),l+=o?d:u;for(n=0;n<t;n+=1)c+=l+"\n"}return c.substring(0,c.length-1)},v.renderTo2dContext=function(t,e){e=e||2;for(var i=v.getModuleCount(),r=0;r<i;r++)for(var n=0;n<i;n++)t.fillStyle=v.isDark(r,n)?"black":"white",t.fillRect(r*e,n*e,e,e)},v};t.stringToBytes=(t.stringToBytesFuncs={default:function(t){for(var e=[],i=0;i<t.length;i+=1){var r=t.charCodeAt(i);e.push(255&r)}return e}}).default,t.createStringToBytes=function(t,e){var i=function(){for(var i=v(t),r=function(){var t=i.read();if(-1==t)throw"eof";return t},n=0,o={};;){var s=i.read();if(-1==s)break;var a=r(),h=r()<<8|r();o[String.fromCharCode(s<<8|a)]=h,n+=1}if(n!=e)throw n+" != "+e;return o}(),r="?".charCodeAt(0);return function(t){for(var e=[],n=0;n<t.length;n+=1){var o=t.charCodeAt(n);if(o<128)e.push(o);else{var s=i[t.charAt(n)];"number"==typeof s?(255&s)==s?e.push(s):(e.push(s>>>8),e.push(255&s)):e.push(r)}}return e}};var e,i,r,n,o,s={L:1,M:0,Q:3,H:2},a=(e=[[],[6,18],[6,22],[6,26],[6,30],[6,34],[6,22,38],[6,24,42],[6,26,46],[6,28,50],[6,30,54],[6,32,58],[6,34,62],[6,26,46,66],[6,26,48,70],[6,26,50,74],[6,30,54,78],[6,30,56,82],[6,30,58,86],[6,34,62,90],[6,28,50,72,94],[6,26,50,74,98],[6,30,54,78,102],[6,28,54,80,106],[6,32,58,84,110],[6,30,58,86,114],[6,34,62,90,118],[6,26,50,74,98,122],[6,30,54,78,102,126],[6,26,52,78,104,130],[6,30,56,82,108,134],[6,34,60,86,112,138],[6,30,58,86,114,142],[6,34,62,90,118,146],[6,30,54,78,102,126,150],[6,24,50,76,102,128,154],[6,28,54,80,106,132,158],[6,32,58,84,110,136,162],[6,26,54,82,110,138,166],[6,30,58,86,114,142,170]],i=1335,r=7973,o=function(t){for(var e=0;0!=t;)e+=1,t>>>=1;return e},(n={}).getBCHTypeInfo=function(t){for(var e=t<<10;o(e)-o(i)>=0;)e^=i<<o(e)-o(i);return 21522^(t<<10|e)},n.getBCHTypeNumber=function(t){for(var e=t<<12;o(e)-o(r)>=0;)e^=r<<o(e)-o(r);return t<<12|e},n.getPatternPosition=function(t){return e[t-1]},n.getMaskFunction=function(t){switch(t){case 0:return function(t,e){return(t+e)%2==0};case 1:return function(t,e){return t%2==0};case 2:return function(t,e){return e%3==0};case 3:return function(t,e){return(t+e)%3==0};case 4:return function(t,e){return(Math.floor(t/2)+Math.floor(e/3))%2==0};case 5:return function(t,e){return t*e%2+t*e%3==0};case 6:return function(t,e){return(t*e%2+t*e%3)%2==0};case 7:return function(t,e){return(t*e%3+(t+e)%2)%2==0};default:throw"bad maskPattern:"+t}},n.getErrorCorrectPolynomial=function(t){for(var e=d([1],0),i=0;i<t;i+=1)e=e.multiply(d([1,h.gexp(i)],0));return e},n.getLengthInBits=function(t,e){if(1<=e&&e<10)switch(t){case 1:return 10;case 2:return 9;case 4:case 8:return 8;default:throw"mode:"+t}else if(e<27)switch(t){case 1:return 12;case 2:return 11;case 4:return 16;case 8:return 10;default:throw"mode:"+t}else{if(!(e<41))throw"type:"+e;switch(t){case 1:return 14;case 2:return 13;case 4:return 16;case 8:return 12;default:throw"mode:"+t}}},n.getLostPoint=function(t){for(var e=t.getModuleCount(),i=0,r=0;r<e;r+=1)for(var n=0;n<e;n+=1){for(var o=0,s=t.isDark(r,n),a=-1;a<=1;a+=1)if(!(r+a<0||e<=r+a))for(var h=-1;h<=1;h+=1)n+h<0||e<=n+h||0==a&&0==h||s==t.isDark(r+a,n+h)&&(o+=1);o>5&&(i+=3+o-5)}for(r=0;r<e-1;r+=1)for(n=0;n<e-1;n+=1){var d=0;t.isDark(r,n)&&(d+=1),t.isDark(r+1,n)&&(d+=1),t.isDark(r,n+1)&&(d+=1),t.isDark(r+1,n+1)&&(d+=1),0!=d&&4!=d||(i+=3)}for(r=0;r<e;r+=1)for(n=0;n<e-6;n+=1)t.isDark(r,n)&&!t.isDark(r,n+1)&&t.isDark(r,n+2)&&t.isDark(r,n+3)&&t.isDark(r,n+4)&&!t.isDark(r,n+5)&&t.isDark(r,n+6)&&(i+=40);for(n=0;n<e;n+=1)for(r=0;r<e-6;r+=1)t.isDark(r,n)&&!t.isDark(r+1,n)&&t.isDark(r+2,n)&&t.isDark(r+3,n)&&t.isDark(r+4,n)&&!t.isDark(r+5,n)&&t.isDark(r+6,n)&&(i+=40);var u=0;for(n=0;n<e;n+=1)for(r=0;r<e;r+=1)t.isDark(r,n)&&(u+=1);return i+Math.abs(100*u/e/e-50)/5*10},n),h=function(){for(var t=new Array(256),e=new Array(256),i=0;i<8;i+=1)t[i]=1<<i;for(i=8;i<256;i+=1)t[i]=t[i-4]^t[i-5]^t[i-6]^t[i-8];for(i=0;i<255;i+=1)e[t[i]]=i;return{glog:function(t){if(t<1)throw"glog("+t+")";return e[t]},gexp:function(e){for(;e<0;)e+=255;for(;e>=256;)e-=255;return t[e]}}}();function d(t,e){if(void 0===t.length)throw t.length+"/"+e;var i=function(){for(var i=0;i<t.length&&0==t[i];)i+=1;for(var r=new Array(t.length-i+e),n=0;n<t.length-i;n+=1)r[n]=t[n+i];return r}(),r={getAt:function(t){return i[t]},getLength:function(){return i.length},multiply:function(t){for(var e=new Array(r.getLength()+t.getLength()-1),i=0;i<r.getLength();i+=1)for(var n=0;n<t.getLength();n+=1)e[i+n]^=h.gexp(h.glog(r.getAt(i))+h.glog(t.getAt(n)));return d(e,0)},mod:function(t){if(r.getLength()-t.getLength()<0)return r;for(var e=h.glog(r.getAt(0))-h.glog(t.getAt(0)),i=new Array(r.getLength()),n=0;n<r.getLength();n+=1)i[n]=r.getAt(n);for(n=0;n<t.getLength();n+=1)i[n]^=h.gexp(h.glog(t.getAt(n))+e);return d(i,0).mod(t)}};return r}var u=function(){var t=[[1,26,19],[1,26,16],[1,26,13],[1,26,9],[1,44,34],[1,44,28],[1,44,22],[1,44,16],[1,70,55],[1,70,44],[2,35,17],[2,35,13],[1,100,80],[2,50,32],[2,50,24],[4,25,9],[1,134,108],[2,67,43],[2,33,15,2,34,16],[2,33,11,2,34,12],[2,86,68],[4,43,27],[4,43,19],[4,43,15],[2,98,78],[4,49,31],[2,32,14,4,33,15],[4,39,13,1,40,14],[2,121,97],[2,60,38,2,61,39],[4,40,18,2,41,19],[4,40,14,2,41,15],[2,146,116],[3,58,36,2,59,37],[4,36,16,4,37,17],[4,36,12,4,37,13],[2,86,68,2,87,69],[4,69,43,1,70,44],[6,43,19,2,44,20],[6,43,15,2,44,16],[4,101,81],[1,80,50,4,81,51],[4,50,22,4,51,23],[3,36,12,8,37,13],[2,116,92,2,117,93],[6,58,36,2,59,37],[4,46,20,6,47,21],[7,42,14,4,43,15],[4,133,107],[8,59,37,1,60,38],[8,44,20,4,45,21],[12,33,11,4,34,12],[3,145,115,1,146,116],[4,64,40,5,65,41],[11,36,16,5,37,17],[11,36,12,5,37,13],[5,109,87,1,110,88],[5,65,41,5,66,42],[5,54,24,7,55,25],[11,36,12,7,37,13],[5,122,98,1,123,99],[7,73,45,3,74,46],[15,43,19,2,44,20],[3,45,15,13,46,16],[1,135,107,5,136,108],[10,74,46,1,75,47],[1,50,22,15,51,23],[2,42,14,17,43,15],[5,150,120,1,151,121],[9,69,43,4,70,44],[17,50,22,1,51,23],[2,42,14,19,43,15],[3,141,113,4,142,114],[3,70,44,11,71,45],[17,47,21,4,48,22],[9,39,13,16,40,14],[3,135,107,5,136,108],[3,67,41,13,68,42],[15,54,24,5,55,25],[15,43,15,10,44,16],[4,144,116,4,145,117],[17,68,42],[17,50,22,6,51,23],[19,46,16,6,47,17],[2,139,111,7,140,112],[17,74,46],[7,54,24,16,55,25],[34,37,13],[4,151,121,5,152,122],[4,75,47,14,76,48],[11,54,24,14,55,25],[16,45,15,14,46,16],[6,147,117,4,148,118],[6,73,45,14,74,46],[11,54,24,16,55,25],[30,46,16,2,47,17],[8,132,106,4,133,107],[8,75,47,13,76,48],[7,54,24,22,55,25],[22,45,15,13,46,16],[10,142,114,2,143,115],[19,74,46,4,75,47],[28,50,22,6,51,23],[33,46,16,4,47,17],[8,152,122,4,153,123],[22,73,45,3,74,46],[8,53,23,26,54,24],[12,45,15,28,46,16],[3,147,117,10,148,118],[3,73,45,23,74,46],[4,54,24,31,55,25],[11,45,15,31,46,16],[7,146,116,7,147,117],[21,73,45,7,74,46],[1,53,23,37,54,24],[19,45,15,26,46,16],[5,145,115,10,146,116],[19,75,47,10,76,48],[15,54,24,25,55,25],[23,45,15,25,46,16],[13,145,115,3,146,116],[2,74,46,29,75,47],[42,54,24,1,55,25],[23,45,15,28,46,16],[17,145,115],[10,74,46,23,75,47],[10,54,24,35,55,25],[19,45,15,35,46,16],[17,145,115,1,146,116],[14,74,46,21,75,47],[29,54,24,19,55,25],[11,45,15,46,46,16],[13,145,115,6,146,116],[14,74,46,23,75,47],[44,54,24,7,55,25],[59,46,16,1,47,17],[12,151,121,7,152,122],[12,75,47,26,76,48],[39,54,24,14,55,25],[22,45,15,41,46,16],[6,151,121,14,152,122],[6,75,47,34,76,48],[46,54,24,10,55,25],[2,45,15,64,46,16],[17,152,122,4,153,123],[29,74,46,14,75,47],[49,54,24,10,55,25],[24,45,15,46,46,16],[4,152,122,18,153,123],[13,74,46,32,75,47],[48,54,24,14,55,25],[42,45,15,32,46,16],[20,147,117,4,148,118],[40,75,47,7,76,48],[43,54,24,22,55,25],[10,45,15,67,46,16],[19,148,118,6,149,119],[18,75,47,31,76,48],[34,54,24,34,55,25],[20,45,15,61,46,16]],e=function(t,e){var i={};return i.totalCount=t,i.dataCount=e,i},i={getRSBlocks:function(i,r){var n=function(e,i){switch(i){case s.L:return t[4*(e-1)+0];case s.M:return t[4*(e-1)+1];case s.Q:return t[4*(e-1)+2];case s.H:return t[4*(e-1)+3];default:return}}(i,r);if(void 0===n)throw"bad rs block @ typeNumber:"+i+"/errorCorrectionLevel:"+r;for(var o=n.length/3,a=[],h=0;h<o;h+=1)for(var d=n[3*h+0],u=n[3*h+1],c=n[3*h+2],l=0;l<d;l+=1)a.push(e(u,c));return a}};return i}(),c=function(){var t=[],e=0,i={getBuffer:function(){return t},getAt:function(e){var i=Math.floor(e/8);return 1==(t[i]>>>7-e%8&1)},put:function(t,e){for(var r=0;r<e;r+=1)i.putBit(1==(t>>>e-r-1&1))},getLengthInBits:function(){return e},putBit:function(i){var r=Math.floor(e/8);t.length<=r&&t.push(0),i&&(t[r]|=128>>>e%8),e+=1}};return i},l=function(t){var e=t,i={getMode:function(){return 1},getLength:function(t){return e.length},write:function(t){for(var i=e,n=0;n+2<i.length;)t.put(r(i.substring(n,n+3)),10),n+=3;n<i.length&&(i.length-n==1?t.put(r(i.substring(n,n+1)),4):i.length-n==2&&t.put(r(i.substring(n,n+2)),7))}},r=function(t){for(var e=0,i=0;i<t.length;i+=1)e=10*e+n(t.charAt(i));return e},n=function(t){if("0"<=t&&t<="9")return t.charCodeAt(0)-"0".charCodeAt(0);throw"illegal char :"+t};return i},g=function(t){var e=t,i={getMode:function(){return 2},getLength:function(t){return e.length},write:function(t){for(var i=e,n=0;n+1<i.length;)t.put(45*r(i.charAt(n))+r(i.charAt(n+1)),11),n+=2;n<i.length&&t.put(r(i.charAt(n)),6)}},r=function(t){if("0"<=t&&t<="9")return t.charCodeAt(0)-"0".charCodeAt(0);if("A"<=t&&t<="Z")return t.charCodeAt(0)-"A".charCodeAt(0)+10;switch(t){case" ":return 36;case"$":return 37;case"%":return 38;case"*":return 39;case"+":return 40;case"-":return 41;case".":return 42;case"/":return 43;case":":return 44;default:throw"illegal char :"+t}};return i},f=function(e){var i=t.stringToBytes(e);return{getMode:function(){return 4},getLength:function(t){return i.length},write:function(t){for(var e=0;e<i.length;e+=1)t.put(i[e],8)}}},w=function(e){var i=t.stringToBytesFuncs.SJIS;if(!i)throw"sjis not supported.";!function(){var t=i("友");if(2!=t.length||38726!=(t[0]<<8|t[1]))throw"sjis not supported."}();var r=i(e),n={getMode:function(){return 8},getLength:function(t){return~~(r.length/2)},write:function(t){for(var e=r,i=0;i+1<e.length;){var n=(255&e[i])<<8|255&e[i+1];if(33088<=n&&n<=40956)n-=33088;else{if(!(57408<=n&&n<=60351))throw"illegal char at "+(i+1)+"/"+n;n-=49472}n=192*(n>>>8&255)+(255&n),t.put(n,13),i+=2}if(i<e.length)throw"illegal char at "+(i+1)}};return n},p=function(){var t=[],e={writeByte:function(e){t.push(255&e)},writeShort:function(t){e.writeByte(t),e.writeByte(t>>>8)},writeBytes:function(t,i,r){i=i||0,r=r||t.length;for(var n=0;n<r;n+=1)e.writeByte(t[n+i])},writeString:function(t){for(var i=0;i<t.length;i+=1)e.writeByte(t.charCodeAt(i))},toByteArray:function(){return t},toString:function(){var e="";e+="[";for(var i=0;i<t.length;i+=1)i>0&&(e+=","),e+=t[i];return e+"]"}};return e},v=function(t){var e=t,i=0,r=0,n=0,o={read:function(){for(;n<8;){if(i>=e.length){if(0==n)return-1;throw"unexpected end of file./"+n}var t=e.charAt(i);if(i+=1,"="==t)return n=0,-1;t.match(/^\s$/)||(r=r<<6|s(t.charCodeAt(0)),n+=6)}var o=r>>>n-8&255;return n-=8,o}},s=function(t){if(65<=t&&t<=90)return t-65;if(97<=t&&t<=122)return t-97+26;if(48<=t&&t<=57)return t-48+52;if(43==t)return 62;if(47==t)return 63;throw"c:"+t};return o},_=function(t,e,i){for(var r=function(t,e){var i=t,r=e,n=new Array(t*e),o={setPixel:function(t,e,r){n[e*i+t]=r},write:function(t){t.writeString("GIF87a"),t.writeShort(i),t.writeShort(r),t.writeByte(128),t.writeByte(0),t.writeByte(0),t.writeByte(0),t.writeByte(0),t.writeByte(0),t.writeByte(255),t.writeByte(255),t.writeByte(255),t.writeString(","),t.writeShort(0),t.writeShort(0),t.writeShort(i),t.writeShort(r),t.writeByte(0);var e=s(2);t.writeByte(2);for(var n=0;e.length-n>255;)t.writeByte(255),t.writeBytes(e,n,255),n+=255;t.writeByte(e.length-n),t.writeBytes(e,n,e.length-n),t.writeByte(0),t.writeString(";")}},s=function(t){for(var e=1<<t,i=1+(1<<t),r=t+1,o=a(),s=0;s<e;s+=1)o.add(String.fromCharCode(s));o.add(String.fromCharCode(e)),o.add(String.fromCharCode(i));var h,d,u,c=p(),l=(h=c,d=0,u=0,{write:function(t,e){if(t>>>e!=0)throw"length over";for(;d+e>=8;)h.writeByte(255&(t<<d|u)),e-=8-d,t>>>=8-d,u=0,d=0;u|=t<<d,d+=e},flush:function(){d>0&&h.writeByte(u)}});l.write(e,r);var g=0,f=String.fromCharCode(n[g]);for(g+=1;g<n.length;){var w=String.fromCharCode(n[g]);g+=1,o.contains(f+w)?f+=w:(l.write(o.indexOf(f),r),o.size()<4095&&(o.size()==1<<r&&(r+=1),o.add(f+w)),f=w)}return l.write(o.indexOf(f),r),l.write(i,r),l.flush(),c.toByteArray()},a=function(){var t={},e=0,i={add:function(r){if(i.contains(r))throw"dup key:"+r;t[r]=e,e+=1},size:function(){return e},indexOf:function(e){return t[e]},contains:function(e){return void 0!==t[e]}};return i};return o}(t,e),n=0;n<e;n+=1)for(var o=0;o<t;o+=1)r.setPixel(o,n,i(o,n));var s=p();r.write(s);for(var a=function(){var t=0,e=0,i=0,r="",n={},o=function(t){r+=String.fromCharCode(s(63&t))},s=function(t){if(t<0);else{if(t<26)return 65+t;if(t<52)return t-26+97;if(t<62)return t-52+48;if(62==t)return 43;if(63==t)return 47}throw"n:"+t};return n.writeByte=function(r){for(t=t<<8|255&r,e+=8,i+=1;e>=6;)o(t>>>e-6),e-=6},n.flush=function(){if(e>0&&(o(t<<6-e),t=0,e=0),i%3!=0)for(var n=3-i%3,s=0;s<n;s+=1)r+="="},n.toString=function(){return r},n}(),h=s.toByteArray(),d=0;d<h.length;d+=1)a.writeByte(h[d]);return a.flush(),"data:image/gif;base64,"+a};return t}();n.stringToBytesFuncs["UTF-8"]=function(t){return function(t){for(var e=[],i=0;i<t.length;i++){var r=t.charCodeAt(i);r<128?e.push(r):r<2048?e.push(192|r>>6,128|63&r):r<55296||r>=57344?e.push(224|r>>12,128|r>>6&63,128|63&r):(i++,r=65536+((1023&r)<<10|1023&t.charCodeAt(i)),e.push(240|r>>18,128|r>>12&63,128|r>>6&63,128|63&r))}return e}(t)},void 0===(r="function"==typeof(i=function(){return n})?i.apply(e,[]):i)||(t.exports=r)}},e={};function i(r){var n=e[r];if(void 0!==n)return n.exports;var o=e[r]={exports:{}};return t[r](o,o.exports,i),o.exports}i.n=t=>{var e=t&&t.__esModule?()=>t.default:()=>t;return i.d(e,{a:e}),e},i.d=(t,e)=>{for(var r in e)i.o(e,r)&&!i.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:e[r]})},i.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e);var r={};return(()=>{"use strict";i.d(r,{default:()=>$});const t=t=>!!t&&"object"==typeof t&&!Array.isArray(t);function e(i,...r){if(!r.length)return i;const n=r.shift();return void 0!==n&&t(i)&&t(n)?(i=Object.assign({},i),Object.keys(n).forEach((r=>{const o=i[r],s=n[r];Array.isArray(o)&&Array.isArray(s)?i[r]=s:t(o)&&t(s)?i[r]=e(Object.assign({},o),s):i[r]=s})),e(i,...r)):i}function n(t,e){const i=document.createElement("a");i.download=e,i.href=t,document.body.appendChild(i),i.click(),document.body.removeChild(i)}const o={L:.07,M:.15,Q:.25,H:.3};class s{constructor({svg:t,type:e,window:i}){this._svg=t,this._type=e,this._window=i}draw(t,e,i,r){let n;switch(this._type){case"dots":n=this._drawDot;break;case"classy":n=this._drawClassy;break;case"classy-rounded":n=this._drawClassyRounded;break;case"rounded":n=this._drawRounded;break;case"extra-rounded":n=this._drawExtraRounded;break;default:n=this._drawSquare}n.call(this,{x:t,y:e,size:i,getNeighbor:r})}_rotateFigure({x:t,y:e,size:i,rotation:r=0,draw:n}){var o;const s=t+i/2,a=e+i/2;n(),null===(o=this._element)||void 0===o||o.setAttribute("transform",`rotate(${180*r/Math.PI},${s},${a})`)}_basicDot(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","circle"),this._element.setAttribute("cx",String(i+e/2)),this._element.setAttribute("cy",String(r+e/2)),this._element.setAttribute("r",String(e/2))}}))}_basicSquare(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","rect"),this._element.setAttribute("x",String(i)),this._element.setAttribute("y",String(r)),this._element.setAttribute("width",String(e)),this._element.setAttribute("height",String(e))}}))}_basicSideRounded(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","path"),this._element.setAttribute("d",`M ${i} ${r}v ${e}h `+e/2+`a ${e/2} ${e/2}, 0, 0, 0, 0 ${-e}`)}}))}_basicCornerRounded(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","path"),this._element.setAttribute("d",`M ${i} ${r}v ${e}h ${e}v `+-e/2+`a ${e/2} ${e/2}, 0, 0, 0, ${-e/2} ${-e/2}`)}}))}_basicCornerExtraRounded(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","path"),this._element.setAttribute("d",`M ${i} ${r}v ${e}h ${e}a ${e} ${e}, 0, 0, 0, ${-e} ${-e}`)}}))}_basicCornersRounded(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","path"),this._element.setAttribute("d",`M ${i} ${r}v `+e/2+`a ${e/2} ${e/2}, 0, 0, 0, ${e/2} ${e/2}h `+e/2+"v "+-e/2+`a ${e/2} ${e/2}, 0, 0, 0, ${-e/2} ${-e/2}`)}}))}_drawDot({x:t,y:e,size:i}){this._basicDot({x:t,y:e,size:i,rotation:0})}_drawSquare({x:t,y:e,size:i}){this._basicSquare({x:t,y:e,size:i,rotation:0})}_drawRounded({x:t,y:e,size:i,getNeighbor:r}){const n=r?+r(-1,0):0,o=r?+r(1,0):0,s=r?+r(0,-1):0,a=r?+r(0,1):0,h=n+o+s+a;if(0!==h)if(h>2||n&&o||s&&a)this._basicSquare({x:t,y:e,size:i,rotation:0});else{if(2===h){let r=0;return n&&s?r=Math.PI/2:s&&o?r=Math.PI:o&&a&&(r=-Math.PI/2),void this._basicCornerRounded({x:t,y:e,size:i,rotation:r})}if(1===h){let r=0;return s?r=Math.PI/2:o?r=Math.PI:a&&(r=-Math.PI/2),void this._basicSideRounded({x:t,y:e,size:i,rotation:r})}}else this._basicDot({x:t,y:e,size:i,rotation:0})}_drawExtraRounded({x:t,y:e,size:i,getNeighbor:r}){const n=r?+r(-1,0):0,o=r?+r(1,0):0,s=r?+r(0,-1):0,a=r?+r(0,1):0,h=n+o+s+a;if(0!==h)if(h>2||n&&o||s&&a)this._basicSquare({x:t,y:e,size:i,rotation:0});else{if(2===h){let r=0;return n&&s?r=Math.PI/2:s&&o?r=Math.PI:o&&a&&(r=-Math.PI/2),void this._basicCornerExtraRounded({x:t,y:e,size:i,rotation:r})}if(1===h){let r=0;return s?r=Math.PI/2:o?r=Math.PI:a&&(r=-Math.PI/2),void this._basicSideRounded({x:t,y:e,size:i,rotation:r})}}else this._basicDot({x:t,y:e,size:i,rotation:0})}_drawClassy({x:t,y:e,size:i,getNeighbor:r}){const n=r?+r(-1,0):0,o=r?+r(1,0):0,s=r?+r(0,-1):0,a=r?+r(0,1):0;0!==n+o+s+a?n||s?o||a?this._basicSquare({x:t,y:e,size:i,rotation:0}):this._basicCornerRounded({x:t,y:e,size:i,rotation:Math.PI/2}):this._basicCornerRounded({x:t,y:e,size:i,rotation:-Math.PI/2}):this._basicCornersRounded({x:t,y:e,size:i,rotation:Math.PI/2})}_drawClassyRounded({x:t,y:e,size:i,getNeighbor:r}){const n=r?+r(-1,0):0,o=r?+r(1,0):0,s=r?+r(0,-1):0,a=r?+r(0,1):0;0!==n+o+s+a?n||s?o||a?this._basicSquare({x:t,y:e,size:i,rotation:0}):this._basicCornerExtraRounded({x:t,y:e,size:i,rotation:Math.PI/2}):this._basicCornerExtraRounded({x:t,y:e,size:i,rotation:-Math.PI/2}):this._basicCornersRounded({x:t,y:e,size:i,rotation:Math.PI/2})}}const a={dot:"dot",square:"square",extraRounded:"extra-rounded"},h=Object.values(a);class d{constructor({svg:t,type:e,window:i}){this._svg=t,this._type=e,this._window=i}draw(t,e,i,r){let n;switch(this._type){case a.square:n=this._drawSquare;break;case a.extraRounded:n=this._drawExtraRounded;break;default:n=this._drawDot}n.call(this,{x:t,y:e,size:i,rotation:r})}_rotateFigure({x:t,y:e,size:i,rotation:r=0,draw:n}){var o;const s=t+i/2,a=e+i/2;n(),null===(o=this._element)||void 0===o||o.setAttribute("transform",`rotate(${180*r/Math.PI},${s},${a})`)}_basicDot(t){const{size:e,x:i,y:r}=t,n=e/7;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","path"),this._element.setAttribute("clip-rule","evenodd"),this._element.setAttribute("d",`M ${i+e/2} ${r}a ${e/2} ${e/2} 0 1 0 0.1 0zm 0 ${n}a ${e/2-n} ${e/2-n} 0 1 1 -0.1 0Z`)}}))}_basicSquare(t){const{size:e,x:i,y:r}=t,n=e/7;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","path"),this._element.setAttribute("clip-rule","evenodd"),this._element.setAttribute("d",`M ${i} ${r}v ${e}h ${e}v `+-e+"z"+`M ${i+n} ${r+n}h `+(e-2*n)+"v "+(e-2*n)+"h "+(2*n-e)+"z")}}))}_basicExtraRounded(t){const{size:e,x:i,y:r}=t,n=e/7;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","path"),this._element.setAttribute("clip-rule","evenodd"),this._element.setAttribute("d",`M ${i} ${r+2.5*n}v `+2*n+`a ${2.5*n} ${2.5*n}, 0, 0, 0, ${2.5*n} ${2.5*n}h `+2*n+`a ${2.5*n} ${2.5*n}, 0, 0, 0, ${2.5*n} ${2.5*-n}v `+-2*n+`a ${2.5*n} ${2.5*n}, 0, 0, 0, ${2.5*-n} ${2.5*-n}h `+-2*n+`a ${2.5*n} ${2.5*n}, 0, 0, 0, ${2.5*-n} ${2.5*n}`+`M ${i+2.5*n} ${r+n}h `+2*n+`a ${1.5*n} ${1.5*n}, 0, 0, 1, ${1.5*n} ${1.5*n}v `+2*n+`a ${1.5*n} ${1.5*n}, 0, 0, 1, ${1.5*-n} ${1.5*n}h `+-2*n+`a ${1.5*n} ${1.5*n}, 0, 0, 1, ${1.5*-n} ${1.5*-n}v `+-2*n+`a ${1.5*n} ${1.5*n}, 0, 0, 1, ${1.5*n} ${1.5*-n}`)}}))}_drawDot({x:t,y:e,size:i,rotation:r}){this._basicDot({x:t,y:e,size:i,rotation:r})}_drawSquare({x:t,y:e,size:i,rotation:r}){this._basicSquare({x:t,y:e,size:i,rotation:r})}_drawExtraRounded({x:t,y:e,size:i,rotation:r}){this._basicExtraRounded({x:t,y:e,size:i,rotation:r})}}const u={dot:"dot",square:"square"},c=Object.values(u);class l{constructor({svg:t,type:e,window:i}){this._svg=t,this._type=e,this._window=i}draw(t,e,i,r){let n;n=this._type===u.square?this._drawSquare:this._drawDot,n.call(this,{x:t,y:e,size:i,rotation:r})}_rotateFigure({x:t,y:e,size:i,rotation:r=0,draw:n}){var o;const s=t+i/2,a=e+i/2;n(),null===(o=this._element)||void 0===o||o.setAttribute("transform",`rotate(${180*r/Math.PI},${s},${a})`)}_basicDot(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","circle"),this._element.setAttribute("cx",String(i+e/2)),this._element.setAttribute("cy",String(r+e/2)),this._element.setAttribute("r",String(e/2))}}))}_basicSquare(t){const{size:e,x:i,y:r}=t;this._rotateFigure(Object.assign(Object.assign({},t),{draw:()=>{this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","rect"),this._element.setAttribute("x",String(i)),this._element.setAttribute("y",String(r)),this._element.setAttribute("width",String(e)),this._element.setAttribute("height",String(e))}}))}_drawDot({x:t,y:e,size:i,rotation:r}){this._basicDot({x:t,y:e,size:i,rotation:r})}_drawSquare({x:t,y:e,size:i,rotation:r}){this._basicSquare({x:t,y:e,size:i,rotation:r})}}const g="circle",f=[[1,1,1,1,1,1,1],[1,0,0,0,0,0,1],[1,0,0,0,0,0,1],[1,0,0,0,0,0,1],[1,0,0,0,0,0,1],[1,0,0,0,0,0,1],[1,1,1,1,1,1,1]],w=[[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,1,1,1,0,0],[0,0,1,1,1,0,0],[0,0,1,1,1,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0]];class p{constructor(t,e){this._roundSize=t=>this._options.dotsOptions.roundSize?Math.floor(t):t,this._window=e,this._element=this._window.document.createElementNS("http://www.w3.org/2000/svg","svg"),this._element.setAttribute("width",String(t.width)),this._element.setAttribute("height",String(t.height)),this._element.setAttribute("xmlns:xlink","http://www.w3.org/1999/xlink"),t.dotsOptions.roundSize||this._element.setAttribute("shape-rendering","crispEdges"),this._element.setAttribute("viewBox",`0 0 ${t.width} ${t.height}`),this._defs=this._window.document.createElementNS("http://www.w3.org/2000/svg","defs"),this._element.appendChild(this._defs),this._imageUri=t.image,this._instanceId=p.instanceCount++,this._options=t}get width(){return this._options.width}get height(){return this._options.height}getElement(){return this._element}async drawQR(t){const e=t.getModuleCount(),i=Math.min(this._options.width,this._options.height)-2*this._options.margin,r=this._options.shape===g?i/Math.sqrt(2):i,n=this._roundSize(r/e);let s={hideXDots:0,hideYDots:0,width:0,height:0};if(this._qr=t,this._options.image){if(await this.loadImage(),!this._image)return;const{imageOptions:t,qrOptions:i}=this._options,r=t.imageSize*o[i.errorCorrectionLevel],a=Math.floor(r*e*e);s=function({originalHeight:t,originalWidth:e,maxHiddenDots:i,maxHiddenAxisDots:r,dotSize:n}){const o={x:0,y:0},s={x:0,y:0};if(t<=0||e<=0||i<=0||n<=0)return{height:0,width:0,hideYDots:0,hideXDots:0};const a=t/e;return o.x=Math.floor(Math.sqrt(i/a)),o.x<=0&&(o.x=1),r&&r<o.x&&(o.x=r),o.x%2==0&&o.x--,s.x=o.x*n,o.y=1+2*Math.ceil((o.x*a-1)/2),s.y=Math.round(s.x*a),(o.y*o.x>i||r&&r<o.y)&&(r&&r<o.y?(o.y=r,o.y%2==0&&o.x--):o.y-=2,s.y=o.y*n,o.x=1+2*Math.ceil((o.y/a-1)/2),s.x=Math.round(s.y/a)),{height:s.y,width:s.x,hideYDots:o.y,hideXDots:o.x}}({originalWidth:this._image.width,originalHeight:this._image.height,maxHiddenDots:a,maxHiddenAxisDots:e-14,dotSize:n})}this.drawBackground(),this.drawDots(((t,i)=>{var r,n,o,a,h,d;return!(this._options.imageOptions.hideBackgroundDots&&t>=(e-s.hideYDots)/2&&t<(e+s.hideYDots)/2&&i>=(e-s.hideXDots)/2&&i<(e+s.hideXDots)/2||(null===(r=f[t])||void 0===r?void 0:r[i])||(null===(n=f[t-e+7])||void 0===n?void 0:n[i])||(null===(o=f[t])||void 0===o?void 0:o[i-e+7])||(null===(a=w[t])||void 0===a?void 0:a[i])||(null===(h=w[t-e+7])||void 0===h?void 0:h[i])||(null===(d=w[t])||void 0===d?void 0:d[i-e+7]))})),this.drawCorners(),this._options.image&&await this.drawImage({width:s.width,height:s.height,count:e,dotSize:n})}drawBackground(){var t,e,i;const r=this._element,n=this._options;if(r){const r=null===(t=n.backgroundOptions)||void 0===t?void 0:t.gradient,o=null===(e=n.backgroundOptions)||void 0===e?void 0:e.color;let s=n.height,a=n.width;if(r||o){const t=this._window.document.createElementNS("http://www.w3.org/2000/svg","rect");this._backgroundClipPath=this._window.document.createElementNS("http://www.w3.org/2000/svg","clipPath"),this._backgroundClipPath.setAttribute("id",`clip-path-background-color-${this._instanceId}`),this._defs.appendChild(this._backgroundClipPath),(null===(i=n.backgroundOptions)||void 0===i?void 0:i.round)&&(s=a=Math.min(n.width,n.height),t.setAttribute("rx",String(s/2*n.backgroundOptions.round))),t.setAttribute("x",String(this._roundSize((n.width-a)/2))),t.setAttribute("y",String(this._roundSize((n.height-s)/2))),t.setAttribute("width",String(a)),t.setAttribute("height",String(s)),this._backgroundClipPath.appendChild(t),this._createColor({options:r,color:o,additionalRotation:0,x:0,y:0,height:n.height,width:n.width,name:`background-color-${this._instanceId}`})}}}drawDots(t){var e,i;if(!this._qr)throw"QR code is not defined";const r=this._options,n=this._qr.getModuleCount();if(n>r.width||n>r.height)throw"The canvas is too small.";const o=Math.min(r.width,r.height)-2*r.margin,a=r.shape===g?o/Math.sqrt(2):o,h=this._roundSize(a/n),d=this._roundSize((r.width-n*h)/2),u=this._roundSize((r.height-n*h)/2),c=new s({svg:this._element,type:r.dotsOptions.type,window:this._window});this._dotsClipPath=this._window.document.createElementNS("http://www.w3.org/2000/svg","clipPath"),this._dotsClipPath.setAttribute("id",`clip-path-dot-color-${this._instanceId}`),this._defs.appendChild(this._dotsClipPath),this._createColor({options:null===(e=r.dotsOptions)||void 0===e?void 0:e.gradient,color:r.dotsOptions.color,additionalRotation:0,x:0,y:0,height:r.height,width:r.width,name:`dot-color-${this._instanceId}`});for(let e=0;e<n;e++)for(let r=0;r<n;r++)t&&!t(e,r)||(null===(i=this._qr)||void 0===i?void 0:i.isDark(e,r))&&(c.draw(d+r*h,u+e*h,h,((i,o)=>!(r+i<0||e+o<0||r+i>=n||e+o>=n)&&!(t&&!t(e+o,r+i))&&!!this._qr&&this._qr.isDark(e+o,r+i))),c._element&&this._dotsClipPath&&this._dotsClipPath.appendChild(c._element));if(r.shape===g){const t=this._roundSize((o/h-n)/2),e=n+2*t,i=d-t*h,r=u-t*h,s=[],a=this._roundSize(e/2);for(let i=0;i<e;i++){s[i]=[];for(let r=0;r<e;r++)i>=t-1&&i<=e-t&&r>=t-1&&r<=e-t||Math.sqrt((i-a)*(i-a)+(r-a)*(r-a))>a?s[i][r]=0:s[i][r]=this._qr.isDark(r-2*t<0?r:r>=n?r-2*t:r-t,i-2*t<0?i:i>=n?i-2*t:i-t)?1:0}for(let t=0;t<e;t++)for(let n=0;n<e;n++)s[t][n]&&(c.draw(i+n*h,r+t*h,h,((e,i)=>{var r;return!!(null===(r=s[t+i])||void 0===r?void 0:r[n+e])})),c._element&&this._dotsClipPath&&this._dotsClipPath.appendChild(c._element))}}drawCorners(){if(!this._qr)throw"QR code is not defined";const t=this._element,e=this._options;if(!t)throw"Element code is not defined";const i=this._qr.getModuleCount(),r=Math.min(e.width,e.height)-2*e.margin,n=e.shape===g?r/Math.sqrt(2):r,o=this._roundSize(n/i),a=7*o,u=3*o,p=this._roundSize((e.width-i*o)/2),v=this._roundSize((e.height-i*o)/2);[[0,0,0],[1,0,Math.PI/2],[0,1,-Math.PI/2]].forEach((([t,r,n])=>{var g,_,m,b,y,x,S,C,A,M,$,O,D,k;const z=p+t*o*(i-7),B=v+r*o*(i-7);let P=this._dotsClipPath,I=this._dotsClipPath;if(((null===(g=e.cornersSquareOptions)||void 0===g?void 0:g.gradient)||(null===(_=e.cornersSquareOptions)||void 0===_?void 0:_.color))&&(P=this._window.document.createElementNS("http://www.w3.org/2000/svg","clipPath"),P.setAttribute("id",`clip-path-corners-square-color-${t}-${r}-${this._instanceId}`),this._defs.appendChild(P),this._cornersSquareClipPath=this._cornersDotClipPath=I=P,this._createColor({options:null===(m=e.cornersSquareOptions)||void 0===m?void 0:m.gradient,color:null===(b=e.cornersSquareOptions)||void 0===b?void 0:b.color,additionalRotation:n,x:z,y:B,height:a,width:a,name:`corners-square-color-${t}-${r}-${this._instanceId}`})),(null===(y=e.cornersSquareOptions)||void 0===y?void 0:y.type)&&h.includes(e.cornersSquareOptions.type)){const t=new d({svg:this._element,type:e.cornersSquareOptions.type,window:this._window});t.draw(z,B,a,n),t._element&&P&&P.appendChild(t._element)}else{const t=new s({svg:this._element,type:(null===(x=e.cornersSquareOptions)||void 0===x?void 0:x.type)||e.dotsOptions.type,window:this._window});for(let e=0;e<f.length;e++)for(let i=0;i<f[e].length;i++)(null===(S=f[e])||void 0===S?void 0:S[i])&&(t.draw(z+i*o,B+e*o,o,((t,r)=>{var n;return!!(null===(n=f[e+r])||void 0===n?void 0:n[i+t])})),t._element&&P&&P.appendChild(t._element))}if(((null===(C=e.cornersDotOptions)||void 0===C?void 0:C.gradient)||(null===(A=e.cornersDotOptions)||void 0===A?void 0:A.color))&&(I=this._window.document.createElementNS("http://www.w3.org/2000/svg","clipPath"),I.setAttribute("id",`clip-path-corners-dot-color-${t}-${r}-${this._instanceId}`),this._defs.appendChild(I),this._cornersDotClipPath=I,this._createColor({options:null===(M=e.cornersDotOptions)||void 0===M?void 0:M.gradient,color:null===($=e.cornersDotOptions)||void 0===$?void 0:$.color,additionalRotation:n,x:z+2*o,y:B+2*o,height:u,width:u,name:`corners-dot-color-${t}-${r}-${this._instanceId}`})),(null===(O=e.cornersDotOptions)||void 0===O?void 0:O.type)&&c.includes(e.cornersDotOptions.type)){const t=new l({svg:this._element,type:e.cornersDotOptions.type,window:this._window});t.draw(z+2*o,B+2*o,u,n),t._element&&I&&I.appendChild(t._element)}else{const t=new s({svg:this._element,type:(null===(D=e.cornersDotOptions)||void 0===D?void 0:D.type)||e.dotsOptions.type,window:this._window});for(let e=0;e<w.length;e++)for(let i=0;i<w[e].length;i++)(null===(k=w[e])||void 0===k?void 0:k[i])&&(t.draw(z+i*o,B+e*o,o,((t,r)=>{var n;return!!(null===(n=w[e+r])||void 0===n?void 0:n[i+t])})),t._element&&I&&I.appendChild(t._element))}}))}loadImage(){return new Promise(((t,e)=>{var i;const r=this._options;if(!r.image)return e("Image is not defined");if(null===(i=r.nodeCanvas)||void 0===i?void 0:i.loadImage)r.nodeCanvas.loadImage(r.image).then((e=>{var i,n;if(this._image=e,this._options.imageOptions.saveAsBlob){const t=null===(i=r.nodeCanvas)||void 0===i?void 0:i.createCanvas(this._image.width,this._image.height);null===(n=null==t?void 0:t.getContext("2d"))||void 0===n||n.drawImage(e,0,0),this._imageUri=null==t?void 0:t.toDataURL()}t()})).catch(e);else{const e=new this._window.Image;"string"==typeof r.imageOptions.crossOrigin&&(e.crossOrigin=r.imageOptions.crossOrigin),this._image=e,e.onload=async()=>{this._options.imageOptions.saveAsBlob&&(this._imageUri=await async function(t,e){return new Promise((i=>{const r=new e.XMLHttpRequest;r.onload=function(){const t=new e.FileReader;t.onloadend=function(){i(t.result)},t.readAsDataURL(r.response)},r.open("GET",t),r.responseType="blob",r.send()}))}(r.image||"",this._window)),t()},e.src=r.image}}))}async drawImage({width:t,height:e,count:i,dotSize:r}){const n=this._options,o=this._roundSize((n.width-i*r)/2),s=this._roundSize((n.height-i*r)/2),a=o+this._roundSize(n.imageOptions.margin+(i*r-t)/2),h=s+this._roundSize(n.imageOptions.margin+(i*r-e)/2),d=t-2*n.imageOptions.margin,u=e-2*n.imageOptions.margin,c=this._window.document.createElementNS("http://www.w3.org/2000/svg","image");c.setAttribute("href",this._imageUri||""),c.setAttribute("xlink:href",this._imageUri||""),c.setAttribute("x",String(a)),c.setAttribute("y",String(h)),c.setAttribute("width",`${d}px`),c.setAttribute("height",`${u}px`),this._element.appendChild(c)}_createColor({options:t,color:e,additionalRotation:i,x:r,y:n,height:o,width:s,name:a}){const h=s>o?s:o,d=this._window.document.createElementNS("http://www.w3.org/2000/svg","rect");if(d.setAttribute("x",String(r)),d.setAttribute("y",String(n)),d.setAttribute("height",String(o)),d.setAttribute("width",String(s)),d.setAttribute("clip-path",`url('#clip-path-${a}')`),t){let e;if("radial"===t.type)e=this._window.document.createElementNS("http://www.w3.org/2000/svg","radialGradient"),e.setAttribute("id",a),e.setAttribute("gradientUnits","userSpaceOnUse"),e.setAttribute("fx",String(r+s/2)),e.setAttribute("fy",String(n+o/2)),e.setAttribute("cx",String(r+s/2)),e.setAttribute("cy",String(n+o/2)),e.setAttribute("r",String(h/2));else{const h=((t.rotation||0)+i)%(2*Math.PI),d=(h+2*Math.PI)%(2*Math.PI);let u=r+s/2,c=n+o/2,l=r+s/2,g=n+o/2;d>=0&&d<=.25*Math.PI||d>1.75*Math.PI&&d<=2*Math.PI?(u-=s/2,c-=o/2*Math.tan(h),l+=s/2,g+=o/2*Math.tan(h)):d>.25*Math.PI&&d<=.75*Math.PI?(c-=o/2,u-=s/2/Math.tan(h),g+=o/2,l+=s/2/Math.tan(h)):d>.75*Math.PI&&d<=1.25*Math.PI?(u+=s/2,c+=o/2*Math.tan(h),l-=s/2,g-=o/2*Math.tan(h)):d>1.25*Math.PI&&d<=1.75*Math.PI&&(c+=o/2,u+=s/2/Math.tan(h),g-=o/2,l-=s/2/Math.tan(h)),e=this._window.document.createElementNS("http://www.w3.org/2000/svg","linearGradient"),e.setAttribute("id",a),e.setAttribute("gradientUnits","userSpaceOnUse"),e.setAttribute("x1",String(Math.round(u))),e.setAttribute("y1",String(Math.round(c))),e.setAttribute("x2",String(Math.round(l))),e.setAttribute("y2",String(Math.round(g)))}t.colorStops.forEach((({offset:t,color:i})=>{const r=this._window.document.createElementNS("http://www.w3.org/2000/svg","stop");r.setAttribute("offset",100*t+"%"),r.setAttribute("stop-color",i),e.appendChild(r)})),d.setAttribute("fill",`url('#${a}')`),this._defs.appendChild(e)}else e&&d.setAttribute("fill",e);this._element.appendChild(d)}}p.instanceCount=0;const v=p,_="canvas",m={};for(let t=0;t<=40;t++)m[t]=t;const b={type:_,shape:"square",width:300,height:300,data:"",margin:0,qrOptions:{typeNumber:m[0],mode:void 0,errorCorrectionLevel:"Q"},imageOptions:{saveAsBlob:!0,hideBackgroundDots:!0,imageSize:.4,crossOrigin:void 0,margin:0},dotsOptions:{type:"square",color:"#000",roundSize:!0},backgroundOptions:{round:0,color:"#fff"}};function y(t){const e=Object.assign({},t);if(!e.colorStops||!e.colorStops.length)throw"Field 'colorStops' is required in gradient";return e.rotation?e.rotation=Number(e.rotation):e.rotation=0,e.colorStops=e.colorStops.map((t=>Object.assign(Object.assign({},t),{offset:Number(t.offset)}))),e}function x(t){const e=Object.assign({},t);return e.width=Number(e.width),e.height=Number(e.height),e.margin=Number(e.margin),e.imageOptions=Object.assign(Object.assign({},e.imageOptions),{hideBackgroundDots:Boolean(e.imageOptions.hideBackgroundDots),imageSize:Number(e.imageOptions.imageSize),margin:Number(e.imageOptions.margin)}),e.margin>Math.min(e.width,e.height)&&(e.margin=Math.min(e.width,e.height)),e.dotsOptions=Object.assign({},e.dotsOptions),e.dotsOptions.gradient&&(e.dotsOptions.gradient=y(e.dotsOptions.gradient)),e.cornersSquareOptions&&(e.cornersSquareOptions=Object.assign({},e.cornersSquareOptions),e.cornersSquareOptions.gradient&&(e.cornersSquareOptions.gradient=y(e.cornersSquareOptions.gradient))),e.cornersDotOptions&&(e.cornersDotOptions=Object.assign({},e.cornersDotOptions),e.cornersDotOptions.gradient&&(e.cornersDotOptions.gradient=y(e.cornersDotOptions.gradient))),e.backgroundOptions&&(e.backgroundOptions=Object.assign({},e.backgroundOptions),e.backgroundOptions.gradient&&(e.backgroundOptions.gradient=y(e.backgroundOptions.gradient))),e}var S=i(873),C=i.n(S);function A(t){if(!t)throw new Error("Extension must be defined");"."===t[0]&&(t=t.substring(1));const e={bmp:"image/bmp",gif:"image/gif",ico:"image/vnd.microsoft.icon",jpeg:"image/jpeg",jpg:"image/jpeg",png:"image/png",svg:"image/svg+xml",tif:"image/tiff",tiff:"image/tiff",webp:"image/webp",pdf:"application/pdf"}[t.toLowerCase()];if(!e)throw new Error(`Extension "${t}" is not supported`);return e}class M{constructor(t){(null==t?void 0:t.jsdom)?this._window=new t.jsdom("",{resources:"usable"}).window:this._window=window,this._options=t?x(e(b,t)):b,this.update()}static _clearContainer(t){t&&(t.innerHTML="")}_setupSvg(){if(!this._qr)return;const t=new v(this._options,this._window);this._svg=t.getElement(),this._svgDrawingPromise=t.drawQR(this._qr).then((()=>{var e;this._svg&&(null===(e=this._extension)||void 0===e||e.call(this,t.getElement(),this._options))}))}_setupCanvas(){var t,e;this._qr&&((null===(t=this._options.nodeCanvas)||void 0===t?void 0:t.createCanvas)?(this._nodeCanvas=this._options.nodeCanvas.createCanvas(this._options.width,this._options.height),this._nodeCanvas.width=this._options.width,this._nodeCanvas.height=this._options.height):(this._domCanvas=document.createElement("canvas"),this._domCanvas.width=this._options.width,this._domCanvas.height=this._options.height),this._setupSvg(),this._canvasDrawingPromise=null===(e=this._svgDrawingPromise)||void 0===e?void 0:e.then((()=>{var t;if(!this._svg)return;const e=this._svg,i=(new this._window.XMLSerializer).serializeToString(e),r=btoa(i),n=`data:${A("svg")};base64,${r}`;if(null===(t=this._options.nodeCanvas)||void 0===t?void 0:t.loadImage)return this._options.nodeCanvas.loadImage(n).then((t=>{var e,i;t.width=this._options.width,t.height=this._options.height,null===(i=null===(e=this._nodeCanvas)||void 0===e?void 0:e.getContext("2d"))||void 0===i||i.drawImage(t,0,0)}));{const t=new this._window.Image;return new Promise((e=>{t.onload=()=>{var i,r;null===(r=null===(i=this._domCanvas)||void 0===i?void 0:i.getContext("2d"))||void 0===r||r.drawImage(t,0,0),e()},t.src=n}))}})))}async _getElement(t="png"){if(!this._qr)throw"QR code is empty";return"svg"===t.toLowerCase()?(this._svg&&this._svgDrawingPromise||this._setupSvg(),await this._svgDrawingPromise,this._svg):((this._domCanvas||this._nodeCanvas)&&this._canvasDrawingPromise||this._setupCanvas(),await this._canvasDrawingPromise,this._domCanvas||this._nodeCanvas)}update(t){M._clearContainer(this._container),this._options=t?x(e(this._options,t)):this._options,this._options.data&&(this._qr=C()(this._options.qrOptions.typeNumber,this._options.qrOptions.errorCorrectionLevel),this._qr.addData(this._options.data,this._options.qrOptions.mode||function(t){switch(!0){case/^[0-9]*$/.test(t):return"Numeric";case/^[0-9A-Z $%*+\-./:]*$/.test(t):return"Alphanumeric";default:return"Byte"}}(this._options.data)),this._qr.make(),this._options.type===_?this._setupCanvas():this._setupSvg(),this.append(this._container))}append(t){if(t){if("function"!=typeof t.appendChild)throw"Container should be a single DOM node";this._options.type===_?this._domCanvas&&t.appendChild(this._domCanvas):this._svg&&t.appendChild(this._svg),this._container=t}}applyExtension(t){if(!t)throw"Extension function should be defined.";this._extension=t,this.update()}deleteExtension(){this._extension=void 0,this.update()}async getRawData(t="png"){if(!this._qr)throw"QR code is empty";const e=await this._getElement(t),i=A(t);if(!e)return null;if("svg"===t.toLowerCase()){const t=`<?xml version="1.0" standalone="no"?>\r\n${(new this._window.XMLSerializer).serializeToString(e)}`;return"undefined"==typeof Blob||this._options.jsdom?Buffer.from(t):new Blob([t],{type:i})}return new Promise((t=>{const r=e;if("toBuffer"in r)if("image/png"===i)t(r.toBuffer(i));else if("image/jpeg"===i)t(r.toBuffer(i));else{if("application/pdf"!==i)throw Error("Unsupported extension");t(r.toBuffer(i))}else"toBlob"in r&&r.toBlob(t,i,1)}))}async download(t){if(!this._qr)throw"QR code is empty";if("undefined"==typeof Blob)throw"Cannot download in Node.js, call getRawData instead.";let e="png",i="qr";"string"==typeof t?(e=t,console.warn("Extension is deprecated as argument for 'download' method, please pass object { name: '...', extension: '...' } as argument")):"object"==typeof t&&null!==t&&(t.name&&(i=t.name),t.extension&&(e=t.extension));const r=await this._getElement(e);if(r)if("svg"===e.toLowerCase()){let t=(new XMLSerializer).serializeToString(r);t='<?xml version="1.0" standalone="no"?>\r\n'+t,n(`data:${A(e)};charset=utf-8,${encodeURIComponent(t)}`,`${i}.svg`)}else n(r.toDataURL(A(e)),`${i}.${e}`)}}const $=M})(),r.default})()));
//# sourceMappingURL=qr-code-styling.js.map

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(() => {
"use strict";
/*!*********************************!*\
  !*** ./resources/js/qr-code.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var qr_code_styling__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! qr-code-styling */ "./node_modules/qr-code-styling/lib/qr-code-styling.js");
/* harmony import */ var qr_code_styling__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(qr_code_styling__WEBPACK_IMPORTED_MODULE_0__);


// QR Code Modal functionality
window.QRCodeModal = {
  init: function init() {
    this.bindEvents();
  },
  bindEvents: function bindEvents() {
    var _this = this;
    // Listen for QR code button clicks
    document.addEventListener('click', function (e) {
      if (e.target.closest('.qr-code-btn')) {
        e.preventDefault();
        var button = e.target.closest('.qr-code-btn');
        var qrData = button.dataset.qrData;
        var fishBoxName = button.dataset.fishBoxName;
        _this.showQRModal(qrData, fishBoxName);
      }
    });

    // Close modal when clicking outside or on close button
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('qr-modal-overlay') || e.target.closest('.qr-modal-close')) {
        _this.hideQRModal();
      }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        _this.hideQRModal();
      }
    });
  },
  showQRModal: function showQRModal(qrData, fishBoxName) {
    // Create modal HTML
    var modalHTML = "\n            <div id=\"qr-modal\" class=\"fixed inset-0 z-50 overflow-y-auto qr-modal-overlay\" aria-labelledby=\"modal-title\" role=\"dialog\" aria-modal=\"true\">\n                <div class=\"flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0\">\n                    <div class=\"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity\" aria-hidden=\"true\"></div>\n                    <span class=\"hidden sm:inline-block sm:align-middle sm:h-screen\" aria-hidden=\"true\">&#8203;</span>\n\n                    <div class=\"relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full\">\n                        <!-- Modal Header -->\n                        <div class=\"bg-white px-6 py-4 border-b border-gray-200\">\n                            <div class=\"flex items-center justify-between\">\n                                <h3 class=\"text-lg font-semibold text-gray-900\" id=\"modal-title\">\n                                    QR Code - ".concat(fishBoxName, "\n                                </h3>\n                                <button class=\"qr-modal-close text-gray-400 hover:text-gray-600 transition-colors\">\n                                    <svg class=\"w-6 h-6\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">\n                                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\"></path>\n                                    </svg>\n                                </button>\n                            </div>\n                        </div>\n\n                        <!-- Modal Body -->\n                        <div class=\"bg-white px-6 py-6\">\n                            <div class=\"flex flex-col items-center\">\n                                <div id=\"qr-code-container\" class=\"mb-4\"></div>\n                                <p class=\"text-sm text-gray-600 text-center mb-4\">\n                                    Scan this QR code to view fish box details\n                                </p>\n                                <div class=\"flex space-x-3\">\n                                    <button id=\"download-png\" class=\"px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm\">\n                                        Download PNG\n                                    </button>\n                                    <button id=\"download-svg\" class=\"px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm\">\n                                        Download SVG\n                                    </button>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        ");

    // Add modal to DOM
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Generate QR Code
    this.generateQRCode(qrData);
  },
  generateQRCode: function generateQRCode(data) {
    var qrCode = new (qr_code_styling__WEBPACK_IMPORTED_MODULE_0___default())({
      width: 256,
      height: 256,
      type: "svg",
      data: data,
      dotsOptions: {
        color: "#2563eb",
        // Blue color to match theme
        type: "rounded"
      },
      backgroundOptions: {
        color: "#ffffff"
      },
      cornersSquareOptions: {
        color: "#1d4ed8",
        type: "extra-rounded"
      },
      cornersDotOptions: {
        color: "#1e40af",
        type: "dot"
      },
      qrOptions: {
        errorCorrectionLevel: 'M'
      }
    });

    // Append QR code to container
    var container = document.getElementById('qr-code-container');
    qrCode.append(container);

    // Bind download buttons
    document.getElementById('download-png').addEventListener('click', function () {
      qrCode.download({
        name: "qr-code-".concat(Date.now()),
        extension: 'png'
      });
    });
    document.getElementById('download-svg').addEventListener('click', function () {
      qrCode.download({
        name: "qr-code-".concat(Date.now()),
        extension: 'svg'
      });
    });

    // Store qrCode instance for potential future use
    this.currentQRCode = qrCode;
  },
  hideQRModal: function hideQRModal() {
    var modal = document.getElementById('qr-modal');
    if (modal) {
      modal.remove();
    }
    this.currentQRCode = null;
  }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
  window.QRCodeModal.init();
});
})();

/******/ })()
;