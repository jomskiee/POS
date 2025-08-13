@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'Product Management']
    ];
@endphp

<div class="min-h-screen bg-gray-50 flex" x-data="{ sidebarOpen: true, reportsOpen: false }">
    <!-- Sidebar Component -->
    @include('layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Navbar Component -->
        @include('layouts.partials.navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6" x-data="productManagement()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Product Management</h1>
                    <p class="text-gray-600 mt-2">Manage your products and categories efficiently</p>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-lg mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 px-6">
                            <button @click="activeTab = 'categories'" 
                                    :class="activeTab === 'categories' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Product Categories
                            </button>
                            <button @click="activeTab = 'products'" 
                                    :class="activeTab === 'products' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Product List
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Categories Tab -->
                <div x-show="activeTab === 'categories'" x-transition>
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Product Categories</h3>
                            <button @click="openCategoryModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Category
                            </button>
                        </div>

                        <!-- Categories Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <template x-for="category in categories" :key="category.id">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900" x-text="category.name"></div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500" x-text="category.description"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-900" x-text="category.products_count + ' products'"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button @click="editCategory(category)" class="text-blue-600 hover:text-blue-900 transition-colors mr-3">
                                                    Edit
                                                </button>
                                                <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900 transition-colors">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Products Tab -->
                <div x-show="activeTab === 'products'" x-transition>
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Product List</h3>
                            <div class="flex items-center space-x-4">
                                <select x-model="categoryFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Categories</option>
                                    <template x-for="category in categories" :key="category.id">
                                        <option :value="category.id" x-text="category.name"></option>
                                    </template>
                                </select>
                                <button @click="openProductModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Product
                                </button>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <template x-for="product in filteredProducts()" :key="product.id">
                                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="aspect-w-1 aspect-h-1 mb-4">
                                        <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-1" x-text="product.name"></h4>
                                    <p class="text-sm text-gray-500 mb-2" x-text="product.category"></p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-blue-600" x-text="'$' + product.price"></span>
                                        <span class="text-sm text-gray-500" x-text="product.stock + ' in stock'"></span>
                                    </div>
                                    <div class="mt-3 flex space-x-2">
                                        <button @click="editProduct(product)" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm transition-colors">
                                            Edit
                                        </button>
                                        <button @click="deleteProduct(product.id)" class="flex-1 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-sm transition-colors">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Category Modal -->
                <div x-show="showCategoryModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900" x-text="categoryForm.id ? 'Edit Category' : 'Add New Category'"></h3>
                                <button @click="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form @submit.prevent="saveCategory()">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                        <input type="text" x-model="categoryForm.name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea x-model="categoryForm.description" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button type="button" @click="closeCategoryModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                                        <span x-text="categoryForm.id ? 'Update' : 'Create'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Product Modal -->
                <div x-show="showProductModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900" x-text="productForm.id ? 'Edit Product' : 'Add New Product'"></h3>
                                <button @click="closeProductModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form @submit.prevent="saveProduct()">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Product Name</label>
                                        <input type="text" x-model="productForm.name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Category</label>
                                        <select x-model="productForm.category_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            <option value="">Select Category</option>
                                            <template x-for="category in categories" :key="category.id">
                                                <option :value="category.id" x-text="category.name"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Price</label>
                                        <input type="number" step="0.01" x-model="productForm.price" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                                        <input type="number" x-model="productForm.stock" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea x-model="productForm.description" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button type="button" @click="closeProductModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                                        <span x-text="productForm.id ? 'Update' : 'Create'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function productManagement() {
    return {
        activeTab: 'categories',
        categoryFilter: '',
        showCategoryModal: false,
        showProductModal: false,
        
        categories: [
            { id: 1, name: 'Electronics', description: 'Electronic devices and gadgets', products_count: 15 },
            { id: 2, name: 'Clothing', description: 'Apparel and fashion items', products_count: 8 },
            { id: 3, name: 'Food & Beverages', description: 'Food items and drinks', products_count: 12 },
            { id: 4, name: 'Books', description: 'Books and educational materials', products_count: 6 }
        ],
        
        products: [
            { id: 1, name: 'iPhone 15 Pro', category: 'Electronics', category_id: 1, price: 999.99, stock: 25, description: 'Latest iPhone model' },
            { id: 2, name: 'Samsung Galaxy S24', category: 'Electronics', category_id: 1, price: 899.99, stock: 30, description: 'Samsung flagship phone' },
            { id: 3, name: 'MacBook Air', category: 'Electronics', category_id: 1, price: 1199.99, stock: 15, description: 'Apple laptop' },
            { id: 4, name: 'T-Shirt', category: 'Clothing', category_id: 2, price: 29.99, stock: 50, description: 'Cotton t-shirt' },
            { id: 5, name: 'Jeans', category: 'Clothing', category_id: 2, price: 79.99, stock: 35, description: 'Denim jeans' },
            { id: 6, name: 'Coffee', category: 'Food & Beverages', category_id: 3, price: 12.99, stock: 100, description: 'Premium coffee beans' },
            { id: 7, name: 'Energy Drink', category: 'Food & Beverages', category_id: 3, price: 3.99, stock: 200, description: 'Energy drink' },
            { id: 8, name: 'Programming Book', category: 'Books', category_id: 4, price: 49.99, stock: 20, description: 'Learn programming' }
        ],
        
        categoryForm: {
            id: null,
            name: '',
            description: ''
        },
        
        productForm: {
            id: null,
            name: '',
            category_id: '',
            price: '',
            stock: '',
            description: ''
        },

        filteredProducts() {
            if (this.categoryFilter === '') {
                return this.products;
            }
            return this.products.filter(product => product.category_id == this.categoryFilter);
        },

        openCategoryModal() {
            this.showCategoryModal = true;
            this.resetCategoryForm();
        },

        closeCategoryModal() {
            this.showCategoryModal = false;
            this.resetCategoryForm();
        },

        openProductModal() {
            this.showProductModal = true;
            this.resetProductForm();
        },

        closeProductModal() {
            this.showProductModal = false;
            this.resetProductForm();
        },

        resetCategoryForm() {
            this.categoryForm = {
                id: null,
                name: '',
                description: ''
            };
        },

        resetProductForm() {
            this.productForm = {
                id: null,
                name: '',
                category_id: '',
                price: '',
                stock: '',
                description: ''
            };
        },

        editCategory(category) {
            this.categoryForm = { ...category };
            this.showCategoryModal = true;
        },

        editProduct(product) {
            this.productForm = { ...product };
            this.showProductModal = true;
        },

        saveCategory() {
            if (this.categoryForm.id) {
                // Update existing category
                const index = this.categories.findIndex(c => c.id === this.categoryForm.id);
                if (index !== -1) {
                    this.categories[index] = { ...this.categoryForm };
                }
                alert('Category updated successfully!');
            } else {
                // Add new category
                const newCategory = {
                    ...this.categoryForm,
                    id: this.categories.length + 1,
                    products_count: 0
                };
                this.categories.push(newCategory);
                alert('Category added successfully!');
            }
            this.closeCategoryModal();
        },

        saveProduct() {
            const category = this.categories.find(c => c.id == this.productForm.category_id);
            
            if (this.productForm.id) {
                // Update existing product
                const index = this.products.findIndex(p => p.id === this.productForm.id);
                if (index !== -1) {
                    this.products[index] = {
                        ...this.productForm,
                        category: category ? category.name : ''
                    };
                }
                alert('Product updated successfully!');
            } else {
                // Add new product
                const newProduct = {
                    ...this.productForm,
                    id: this.products.length + 1,
                    category: category ? category.name : ''
                };
                this.products.push(newProduct);
                alert('Product added successfully!');
            }
            this.closeProductModal();
        },

        deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
                this.categories = this.categories.filter(c => c.id !== categoryId);
                alert('Category deleted successfully!');
            }
        },

        deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                this.products = this.products.filter(p => p.id !== productId);
                alert('Product deleted successfully!');
            }
        }
    }
}
</script>
@endsection