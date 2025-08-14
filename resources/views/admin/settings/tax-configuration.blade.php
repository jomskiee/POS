<!-- Tax Configuration Tab Content -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Tax Settings -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tax Configuration</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Tax Rate (%)</label>
                <input type="number" 
                       x-model="settings.tax.defaultRate"
                       step="0.01"
                       min="0"
                       max="100"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tax Display</label>
                <select x-model="settings.tax.display" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="inclusive">Tax Inclusive Pricing</option>
                    <option value="exclusive">Tax Exclusive Pricing</option>
                    <option value="both">Show Both Prices</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tax Calculation</label>
                <select x-model="settings.tax.calculation" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="line">Per Line Item</option>
                    <option value="total">On Total Amount</option>
                </select>
            </div>
            <div class="flex items-center">
                <input type="checkbox" 
                       x-model="settings.tax.enableMultiple"
                       id="enable-multiple-tax"
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="enable-multiple-tax" class="ml-2 text-sm text-gray-700">Enable Multiple Tax Rates</label>
            </div>
        </div>
    </div>

    <!-- Tax Rates List -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Tax Rates</h3>
            <button @click="addTaxRate()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                Add Rate
            </button>
        </div>
        <div class="space-y-3">
            <template x-for="(rate, index) in settings.tax.rates" :key="index">
                <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                    <input type="text" 
                           :value="rate.name"
                           @input="settings.tax.rates[index].name = $event.target.value"
                           placeholder="Tax name"
                           class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    <input type="number" 
                           :value="rate.rate"
                           @input="settings.tax.rates[index].rate = parseFloat($event.target.value)"
                           step="0.01"
                           placeholder="0.00"
                           class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    <span class="text-sm text-gray-500">%</span>
                    <button @click="removeTaxRate(index)" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>