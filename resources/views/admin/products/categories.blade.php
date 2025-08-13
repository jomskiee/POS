<!-- Categories Tab Content -->
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Product Categories</h2>
    <button @click="openAddCategoryModal()" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>Add Category</span>
    </button>
</div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <template x-for="category in categories" :key="category.id">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7l2 2-2 2m0 4l2 2-2 2M3 7l2 2-2 2"></path>
                    </svg>
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="alert('Edit category functionality - implement server-side')"
                            class="text-gray-400 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button @click="deleteCategory(category.id)"
                            class="text-gray-400 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
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