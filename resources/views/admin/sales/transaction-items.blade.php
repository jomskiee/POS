<!-- Transaction List Items Tab Content -->
<div class="space-y-6" x-data="transactionItems()">
    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Transaction List Items</h2>
                <p class="text-gray-600 mt-1">Detailed breakdown of all individual items sold across transactions</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <input type="text" 
                           x-model="searchQuery"
                           placeholder="Search products or transaction IDs..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <select x-model="categoryFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Categories</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="food">Food & Beverages</option>
                    <option value="books">Books</option>
                </select>
                <select x-model="dateFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                <button @click="exportItems()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Export</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Items Sold</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="summary.totalItems.toLocaleString()"></p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Unique Products</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="summary.uniqueProducts"></p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Average Items per Transaction</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="summary.avgItemsPerTransaction.toFixed(1)"></p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Item Value</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="formatCurrency(summary.totalValue)"></p>
                </div>
                <div class="bg-orange-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Items Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Individual Transaction Items</h3>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500" x-text="`Showing ${filteredItems.length} items`"></span>
                    <select x-model="sortBy" class="px-3 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="date">Sort by Date</option>
                        <option value="product">Sort by Product</option>
                        <option value="quantity">Sort by Quantity</option>
                        <option value="price">Sort by Price</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="item in filteredItems" :key="item.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-blue-600 hover:text-blue-800 cursor-pointer" @click="viewTransaction(item.transaction_id)" x-text="item.transaction_id"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="item.date"></div>
                                <div class="text-xs text-gray-500" x-text="item.time"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900" x-text="item.product_name"></div>
                                        <div class="text-xs text-gray-500" x-text="item.sku"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" 
                                      :class="getCategoryColor(item.category)"
                                      x-text="item.category"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="item.quantity"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="formatCurrency(item.unit_price)"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="formatCurrency(item.total_price)"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" 
                                :class="item.profit >= 0 ? 'text-green-600' : 'text-red-600'" 
                                x-text="formatCurrency(item.profit)"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button @click="viewDetails(item)" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button @click="processReturn(item)" class="text-orange-600 hover:text-orange-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-6 py-3 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing <span x-text="((currentPage - 1) * itemsPerPage) + 1"></span> to 
                    <span x-text="Math.min(currentPage * itemsPerPage, filteredItems.length)"></span> of 
                    <span x-text="filteredItems.length"></span> results
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="previousPage()" :disabled="currentPage === 1" 
                            class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50">
                        Previous
                    </button>
                    <span class="px-3 py-1 text-sm bg-blue-600 text-white rounded" x-text="currentPage"></span>
                    <button @click="nextPage()" :disabled="currentPage * itemsPerPage >= filteredItems.length"
                            class="px-3 py-1 text-sm border border-gray-300 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function transactionItems() {
    return {
        searchQuery: '',
        categoryFilter: '',
        dateFilter: '',
        sortBy: 'date',
        currentPage: 1,
        itemsPerPage: 15,
        
        summary: {
            totalItems: 2847,
            uniqueProducts: 156,
            avgItemsPerTransaction: 2.3,
            totalValue: 89420.75
        },
        
        items: [
            {
                id: 1,
                transaction_id: '#T-2024-001',
                date: 'Dec 26, 2024',
                time: '2:30 PM',
                product_name: 'iPhone 15 Pro',
                sku: 'IPH-15P-256',
                category: 'Electronics',
                quantity: 1,
                unit_price: 999.99,
                total_price: 999.99,
                profit: 249.99
            },
            {
                id: 2,
                transaction_id: '#T-2024-001',
                date: 'Dec 26, 2024',
                time: '2:30 PM',
                product_name: 'Phone Case',
                sku: 'CASE-IPH15',
                category: 'Electronics',
                quantity: 1,
                unit_price: 49.99,
                total_price: 49.99,
                profit: 25.00
            },
            {
                id: 3,
                transaction_id: '#T-2024-002',
                date: 'Dec 26, 2024',
                time: '1:45 PM',
                product_name: 'Coffee Beans Premium',
                sku: 'COF-PREM-1LB',
                category: 'Food & Beverages',
                quantity: 3,
                unit_price: 24.99,
                total_price: 74.97,
                profit: 29.97
            },
            {
                id: 4,
                transaction_id: '#T-2024-003',
                date: 'Dec 26, 2024',
                time: '12:15 PM',
                product_name: 'Samsung Galaxy S24',
                sku: 'SAM-S24-128',
                category: 'Electronics',
                quantity: 1,
                unit_price: 899.99,
                total_price: 899.99,
                profit: 249.99
            },
            {
                id: 5,
                transaction_id: '#T-2024-004',
                date: 'Dec 26, 2024',
                time: '11:30 AM',
                product_name: 'Nike Air Max',
                sku: 'NIK-AM-42',
                category: 'Clothing',
                quantity: 1,
                unit_price: 129.99,
                total_price: 129.99,
                profit: 49.99
            },
            {
                id: 6,
                transaction_id: '#T-2024-004',
                date: 'Dec 26, 2024',
                time: '11:30 AM',
                product_name: 'Athletic Socks',
                sku: 'SOC-ATH-L',
                category: 'Clothing',
                quantity: 2,
                unit_price: 9.99,
                total_price: 19.98,
                profit: 9.98
            },
            {
                id: 7,
                transaction_id: '#T-2024-005',
                date: 'Dec 26, 2024',
                time: '10:45 AM',
                product_name: 'MacBook Pro 16',
                sku: 'MBP-16-512',
                category: 'Electronics',
                quantity: 1,
                unit_price: 2499.99,
                total_price: 2499.99,
                profit: 699.99
            },
            {
                id: 8,
                transaction_id: '#T-2024-006',
                date: 'Dec 25, 2024',
                time: '4:20 PM',
                product_name: 'Programming Book',
                sku: 'BK-PROG-JS',
                category: 'Books',
                quantity: 2,
                unit_price: 39.99,
                total_price: 79.98,
                profit: 23.98
            }
        ],
        
        get filteredItems() {
            let filtered = this.items;
            
            // Apply search filter
            if (this.searchQuery) {
                filtered = filtered.filter(item => 
                    item.product_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    item.transaction_id.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    item.sku.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
            
            // Apply category filter
            if (this.categoryFilter) {
                filtered = filtered.filter(item => 
                    item.category.toLowerCase() === this.categoryFilter.toLowerCase()
                );
            }
            
            // Apply date filter (simplified)
            if (this.dateFilter === 'today') {
                filtered = filtered.filter(item => item.date.includes('Dec 26, 2024'));
            }
            
            // Apply sorting
            switch (this.sortBy) {
                case 'product':
                    filtered.sort((a, b) => a.product_name.localeCompare(b.product_name));
                    break;
                case 'quantity':
                    filtered.sort((a, b) => b.quantity - a.quantity);
                    break;
                case 'price':
                    filtered.sort((a, b) => b.total_price - a.total_price);
                    break;
                default: // date
                    filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
            }
            
            return filtered;
        },
        
        formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        },
        
        getCategoryColor(category) {
            const colors = {
                'Electronics': 'bg-blue-100 text-blue-800',
                'Clothing': 'bg-green-100 text-green-800',
                'Food & Beverages': 'bg-purple-100 text-purple-800',
                'Books': 'bg-orange-100 text-orange-800'
            };
            return colors[category] || 'bg-gray-100 text-gray-800';
        },
        
        viewTransaction(transactionId) {
            alert(`Viewing transaction ${transactionId}`);
        },
        
        viewDetails(item) {
            alert(`Viewing details for ${item.product_name}`);
        },
        
        processReturn(item) {
            alert(`Processing return for ${item.product_name}`);
        },
        
        exportItems() {
            alert('Exporting transaction items...');
        },
        
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        
        nextPage() {
            if (this.currentPage * this.itemsPerPage < this.filteredItems.length) {
                this.currentPage++;
            }
        }
    }
}
</script>