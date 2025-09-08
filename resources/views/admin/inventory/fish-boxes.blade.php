<!-- Categories Tab Content -->
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Fish Boxes List</h2>
    <button @click="openAddCategoryModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
        <x-heroicon-o-plus class="w-4 h-4" />
        <span>Add Fish Box</span>
    </button>
</div>

<!-- Products Filters -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <div class="grid grid-cols-12 gap-4 items-center">
        <div class="col-span-12 md:col-span-8">
            <div class="relative">
                <input type="text"
                       placeholder="Search products..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                </div>
            </div>
        </div>
        <div class="col-span-6 md:col-span-2">
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Categories</option>
                <option value="1">Electronics</option>
                <option value="2">Clothing</option>
                <option value="3">Food & Beverages</option>
                <option value="4">Books</option>
            </select>
        </div>
        <div class="col-span-6 md:col-span-2">
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" x-data="{
    categories: [
        {
            id: 1,
            name: 'Electronics',
            description: 'Electronic devices and gadgets',
            product_count: 5,
            created_at: '2024-01-15'
        },
        {
            id: 2,
            name: 'Clothing',
            description: 'Apparel and fashion items',
            product_count: 12,
            created_at: '2024-01-20'
        },
        {
            id: 3,
            name: 'Food & Beverages',
            description: 'Food items and drinks',
            product_count: 8,
            created_at: '2024-02-01'
        },
        {
            id: 4,
            name: 'Books',
            description: 'Books and educational materials',
            product_count: 15,
            created_at: '2024-02-10'
        },
        {
            id: 5,
            name: 'Home & Garden',
            description: 'Home improvement and garden supplies',
            product_count: 6,
            created_at: '2024-02-15'
        },
        {
            id: 6,
            name: 'Sports & Outdoors',
            description: 'Sports equipment and outdoor gear',
            product_count: 9,
            created_at: '2024-02-20'
        }
    ]
}">
    <template x-for="category in categories" :key="category.id">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <x-heroicon-o-archive-box class="w-6 h-6 text-white" />
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="alert('Edit category functionality - implement server-side')"
                            class="text-gray-400 hover:text-blue-600 transition-colors">
                        <x-heroicon-o-pencil-square class="w-6 h-6" />
                    </button>
                    <button @click="deleteCategory(category.id)"
                            class="text-gray-400 hover:text-red-600 transition-colors">
                        <x-heroicon-o-trash class="w-6 h-6" />
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2" x-text="category.name"></h3>
            <p class="text-gray-600 text-sm mb-4" x-text="category.description || 'No description available'"></p>
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span x-text="category.product_count + ' products'"></span>
                <span x-text="new Date(category.created_at).toLocaleDateString()"></span>
            </div>
        </div>
    </template>
</div>