<!-- Products Tab Content -->
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Product Inventory</h2>
    <button @click="openAddProductModal()" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>Add Product</span>
    </button>
</div>

<!-- Products Filters -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <div class="flex flex-wrap items-center space-x-4">
        <div class="flex-1 min-w-64">
            <div class="relative">
                <input type="text" 
                       placeholder="Search products..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Categories</option>
            <option value="1">Electronics</option>
            <option value="2">Clothing</option>
            <option value="3">Food & Beverages</option>
            <option value="4">Books</option>
        </select>
        <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" x-data="{
                products: [
                    {
                        id: 1,
                        name: 'iPhone 15 Pro',
                        category_id: 1,
                        price: 999.99,
                        cost: 750.00,
                        stock_quantity: 25,
                        barcode: '123456789012',
                        status: 'active',
                        description: 'Latest iPhone model'
                    },
                    {
                        id: 2,
                        name: 'Samsung Galaxy S24',
                        category_id: 1,
                        price: 899.99,
                        cost: 650.00,
                        stock_quantity: 18,
                        barcode: '123456789013',
                        status: 'active',
                        description: 'Samsung flagship phone'
                    },
                    {
                        id: 3,
                        name: 'MacBook Pro 16',
                        category_id: 1,
                        price: 2499.99,
                        cost: 1800.00,
                        stock_quantity: 8,
                        barcode: '123456789014',
                        status: 'active',
                        description: 'Apple laptop'
                    },
                    {
                        id: 4,
                        name: 'Nike Air Max',
                        category_id: 2,
                        price: 129.99,
                        cost: 80.00,
                        stock_quantity: 45,
                        barcode: '123456789015',
                        status: 'active',
                        description: 'Popular sneakers'
                    },
                    {
                        id: 5,
                        name: 'Coffee Beans Premium',
                        category_id: 3,
                        price: 24.99,
                        cost: 15.00,
                        stock_quantity: 120,
                        barcode: '123456789016',
                        status: 'active',
                        description: 'Arabica coffee beans'
                    }
                ],
                categories: [
                    { id: 1, name: 'Electronics' },
                    { id: 2, name: 'Clothing' },
                    { id: 3, name: 'Food & Beverages' },
                    { id: 4, name: 'Books' }
                ],
                getCategoryName(categoryId) {
                    const category = this.categories.find(cat => cat.id === categoryId);
                    return category ? category.name : 'Unknown';
                }
            }">
                <template x-for="product in products" :key="product.id">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900" x-text="product.name"></div>
                                    <div class="text-sm text-gray-500" x-text="product.barcode || 'No barcode'"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900" x-text="getCategoryName(product.category_id)"></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">$<span x-text="product.price"></span></div>
                            <div class="text-xs text-gray-500">Cost: $<span x-text="product.cost"></span></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium"
                                 :class="product.stock_quantity <= 5 ? 'text-red-600' : product.stock_quantity <= 10 ? 'text-yellow-600' : 'text-blue-600'"
                                 x-text="product.stock_quantity + ' units'"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                  :class="product.status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800'"
                                  x-text="product.status.charAt(0).toUpperCase() + product.status.slice(1)"></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button @click="alert('Edit product functionality - implement server-side')"
                                        class="text-blue-600 hover:text-blue-900 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button @click="deleteProduct(product.id)"
                                        class="text-red-600 hover:text-red-900 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>