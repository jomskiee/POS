<!-- Receipt Customization Tab Content -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Receipt Settings -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Receipt Configuration</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Receipt Width</label>
                <select x-model="settings.receipt.width" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="58">58mm (Small)</option>
                    <option value="80">80mm (Standard)</option>
                    <option value="112">112mm (Wide)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Paper Type</label>
                <select x-model="settings.receipt.paperType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="thermal">Thermal Paper</option>
                    <option value="impact">Impact Paper</option>
                    <option value="a4">A4 Paper</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Font Size</label>
                <select x-model="settings.receipt.fontSize" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="small">Small (8pt)</option>
                    <option value="medium">Medium (10pt)</option>
                    <option value="large">Large (12pt)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Receipt Template</label>
                <select x-model="settings.receipt.template" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="standard">Standard</option>
                    <option value="minimal">Minimal</option>
                    <option value="detailed">Detailed</option>
                    <option value="modern">Modern</option>
                </select>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <h4 class="text-md font-medium text-gray-900">Display Options</h4>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.receipt.showLogo" id="show-logo" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="show-logo" class="ml-2 text-sm text-gray-700">Show Company Logo</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.receipt.showBarcode" id="show-barcode" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="show-barcode" class="ml-2 text-sm text-gray-700">Show Transaction Barcode</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.receipt.showTaxBreakdown" id="show-tax" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="show-tax" class="ml-2 text-sm text-gray-700">Show Tax Breakdown</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.receipt.showQrCode" id="show-qr" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="show-qr" class="ml-2 text-sm text-gray-700">Show QR Code for Digital Receipt</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Information -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                <input type="text" x-model="settings.receipt.companyName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Your Business Name">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1</label>
                <input type="text" x-model="settings.receipt.address1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Street Address">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                <input type="text" x-model="settings.receipt.address2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="City, State, ZIP">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="text" x-model="settings.receipt.phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="(555) 123-4567">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" x-model="settings.receipt.email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="info@yourbusiness.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                <input type="url" x-model="settings.receipt.website" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="www.yourbusiness.com">
            </div>
        </div>
    </div>
</div>

<!-- Custom Messages -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Custom Messages</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Header Message</label>
                <textarea x-model="settings.receipt.headerMessage" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Welcome message or promotional text"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer Message</label>
                <textarea x-model="settings.receipt.footerMessage" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Thank you message or return policy"></textarea>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Preview -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Receipt Preview</h3>
            <button @click="printTestReceipt()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                Print Test Receipt
            </button>
        </div>
        <div class="bg-gray-50 rounded-lg p-6 max-w-sm mx-auto">
            <div class="bg-white rounded p-4 shadow-sm" style="font-family: 'Courier New', monospace;">
                <div class="text-center mb-4">
                    <div x-show="settings.receipt.showLogo" class="mb-2">
                        <div class="w-16 h-16 bg-gray-200 rounded mx-auto flex items-center justify-center">
                            <span class="text-xs text-gray-500">LOGO</span>
                        </div>
                    </div>
                    <h4 class="font-bold text-sm" x-text="settings.receipt.companyName || 'Your Business Name'"></h4>
                    <p class="text-xs" x-text="settings.receipt.address1 || 'Street Address'"></p>
                    <p class="text-xs" x-text="settings.receipt.address2 || 'City, State, ZIP'"></p>
                    <p class="text-xs" x-text="settings.receipt.phone || '(555) 123-4567'"></p>
                </div>
                
                <div class="border-t border-dashed border-gray-300 my-2"></div>
                
                <div class="text-xs mb-2">
                    <div class="flex justify-between">
                        <span>Date:</span>
                        <span x-text="new Date().toLocaleDateString()"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Receipt #:</span>
                        <span>001234</span>
                    </div>
                </div>
                
                <div class="border-t border-dashed border-gray-300 my-2"></div>
                
                <div class="text-xs">
                    <div class="flex justify-between">
                        <span>Sample Item 1</span>
                        <span>$10.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Sample Item 2</span>
                        <span>$15.50</span>
                    </div>
                </div>
                
                <div class="border-t border-dashed border-gray-300 my-2"></div>
                
                <div class="text-xs">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>$25.50</span>
                    </div>
                    <div x-show="settings.receipt.showTaxBreakdown" class="flex justify-between">
                        <span>Tax:</span>
                        <span>$2.04</span>
                    </div>
                    <div class="flex justify-between font-bold">
                        <span>Total:</span>
                        <span>$27.54</span>
                    </div>
                </div>
                
                <div class="border-t border-dashed border-gray-300 my-2"></div>
                
                <div class="text-center text-xs" x-show="settings.receipt.footerMessage">
                    <p x-text="settings.receipt.footerMessage"></p>
                </div>
                
                <div x-show="settings.receipt.showQrCode" class="text-center mt-2">
                    <div class="w-12 h-12 bg-gray-200 rounded mx-auto flex items-center justify-center">
                        <span class="text-xs text-gray-500">QR</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>