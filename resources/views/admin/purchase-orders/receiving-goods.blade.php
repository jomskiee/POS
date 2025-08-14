<!-- Receiving Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="text-center">
            <p class="text-sm font-medium text-gray-600">Expected Today</p>
            <p class="text-3xl font-bold text-gray-900">8</p>
            <p class="text-sm text-blue-600">Purchase orders</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="text-center">
            <p class="text-sm font-medium text-gray-600">Received Today</p>
            <p class="text-3xl font-bold text-gray-900">5</p>
            <p class="text-sm text-green-600">Deliveries</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="text-center">
            <p class="text-sm font-medium text-gray-600">Pending Receipt</p>
            <p class="text-3xl font-bold text-gray-900">3</p>
            <p class="text-sm text-yellow-600">Outstanding</p>
        </div>
    </div>
</div>

<!-- Receiving Interface -->
<div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Goods Receiving Interface</h3>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">PO Number</label>
            <div class="flex space-x-2">
                <input type="text" 
                       placeholder="Enter PO number"
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Lookup
                </button>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Barcode Scanner</label>
            <div class="flex space-x-2">
                <input type="text" 
                       placeholder="Scan barcode"
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Scan
                </button>
            </div>
        </div>
    </div>
    
    <div class="mt-6 h-64 bg-gray-50 rounded-lg flex items-center justify-center">
        <div class="text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-gray-500">PO Items will appear here</p>
            <p class="text-sm text-gray-400">Enter PO number to load items for receiving</p>
        </div>
    </div>
</div>