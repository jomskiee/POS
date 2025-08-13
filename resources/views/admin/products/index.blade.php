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
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Product Management</h1>
                            <p class="text-gray-600 mt-2">Manage products, categories, and supplies</p>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'products'" 
                                    :class="activeTab === 'products' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span>Products</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'categories'" 
                                    :class="activeTab === 'categories' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7l2 2-2 2m0 4l2 2-2 2M3 7l2 2-2 2"></path>
                                    </svg>
                                    <span>Categories</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'supplies'" 
                                    :class="activeTab === 'supplies' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <span>Supplies</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Products Tab Content -->
                <div x-show="activeTab === 'products'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.products.product-list')
                </div>

                <!-- Categories Tab Content -->
                <div x-show="activeTab === 'categories'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.products.categories')
                </div>

                <!-- Supplies Tab Content -->
                <div x-show="activeTab === 'supplies'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    @include('admin.products.supplies')
                </div>
            </div>

            <!-- Add Category Modal -->
            <div x-show="showAddCategoryModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeAddCategoryModal()">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Add New Category</h3>
                        <button @click="closeAddCategoryModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="addCategory()">
                        <div class="space-y-4">
                            <div>
                                <label for="add_category_name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                                <input type="text" 
                                       id="add_category_name"
                                       x-model="addCategoryForm.name" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="add_category_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="add_category_description"
                                          x-model="addCategoryForm.description" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" 
                                    @click="closeAddCategoryModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    :disabled="addCategoryForm.loading"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors disabled:opacity-50">
                                <span x-show="!addCategoryForm.loading">Add Category</span>
                                <span x-show="addCategoryForm.loading">Adding...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Product Modal -->
            <div x-show="showAddProductModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeAddProductModal()">
                <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Add New Product</h3>
                        <button @click="closeAddProductModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="addProduct()">
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            <div>
                                <label for="add_product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                                <input type="text" 
                                       id="add_product_name"
                                       x-model="addProductForm.name" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="add_product_category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="add_product_category"
                                        x-model="addProductForm.category_id" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Category</option>
                                    <template x-for="category in categories" :key="category.id">
                                        <option :value="category.id" x-text="category.name"></option>
                                    </template>
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="add_product_price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <input type="number" 
                                           id="add_product_price"
                                           x-model="addProductForm.price" 
                                           step="0.01"
                                           min="0"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label for="add_product_cost" class="block text-sm font-medium text-gray-700 mb-1">Cost</label>
                                    <input type="number" 
                                           id="add_product_cost"
                                           x-model="addProductForm.cost" 
                                           step="0.01"
                                           min="0"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            
                            <div>
                                <label for="add_product_stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                                <input type="number" 
                                       id="add_product_stock"
                                       x-model="addProductForm.stock_quantity" 
                                       min="0"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="add_product_barcode" class="block text-sm font-medium text-gray-700 mb-1">Barcode (Optional)</label>
                                <input type="text" 
                                       id="add_product_barcode"
                                       x-model="addProductForm.barcode" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="add_product_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="add_product_status"
                                        x-model="addProductForm.status" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="add_product_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="add_product_description"
                                          x-model="addProductForm.description" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" 
                                    @click="closeAddProductModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    :disabled="addProductForm.loading"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors disabled:opacity-50">
                                <span x-show="!addProductForm.loading">Add Product</span>
                                <span x-show="addProductForm.loading">Adding...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Supply Modal -->
            <div x-show="showAddSupplyModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeAddSupplyModal()">
                <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900" x-text="addSupplyForm.id ? 'Edit Supply' : 'Add New Supply'"></h3>
                        <button @click="closeAddSupplyModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="addSupply()">
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            <div>
                                <label for="add_supply_product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                                <input type="text" 
                                       id="add_supply_product_name"
                                       x-model="addSupplyForm.product_name" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="add_supply_supplier" class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                                <input type="text" 
                                       id="add_supply_supplier"
                                       x-model="addSupplyForm.supplier" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="add_supply_quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="text" 
                                           id="add_supply_quantity"
                                           x-model="addSupplyForm.quantity" 
                                           required
                                           placeholder="e.g., 50 kg, 100 pieces"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label for="add_supply_cost" class="block text-sm font-medium text-gray-700 mb-1">Cost</label>
                                    <input type="number" 
                                           id="add_supply_cost"
                                           x-model="addSupplyForm.cost" 
                                           step="0.01"
                                           min="0"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            
                            <div>
                                <label for="add_supply_date" class="block text-sm font-medium text-gray-700 mb-1">Supply Date</label>
                                <input type="date" 
                                       id="add_supply_date"
                                       x-model="addSupplyForm.date" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="add_supply_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="add_supply_status"
                                        x-model="addSupplyForm.status" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="pending">Pending</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="add_supply_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="add_supply_description"
                                          x-model="addSupplyForm.product_description" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" 
                                    @click="closeAddSupplyModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    :disabled="addSupplyForm.loading"
                                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors disabled:opacity-50">
                                <span x-show="!addSupplyForm.loading" x-text="addSupplyForm.id ? 'Update Supply' : 'Add Supply'"></span>
                                <span x-show="addSupplyForm.loading">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function productManagement() {
    return {
        // State - Changed default tab to 'products'
        activeTab: 'products',
        showAddCategoryModal: false,
        showAddProductModal: false,
        showAddSupplyModal: false,
        productSearchQuery: '',
        productCategoryFilter: '',
        productStatusFilter: '',
        supplySearchQuery: '',
        supplyStatusFilter: '',
        supplyDateFilter: '',
        
        // Form data
        addCategoryForm: {
            name: '',
            description: '',
            loading: false
        },
        
        addProductForm: {
            name: '',
            category_id: '',
            price: '',
            cost: '',
            stock_quantity: '',
            barcode: '',
            status: 'active',
            description: '',
            loading: false
        },

        addSupplyForm: {
            id: null,
            product_name: '',
            supplier: '',
            quantity: '',
            cost: '',
            date: new Date().toISOString().split('T')[0],
            status: 'pending',
            product_description: '',
            loading: false
        },
        
        // Dummy data
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
                product_count: 8,
                created_at: '2024-01-20'
            },
            {
                id: 3,
                name: 'Food & Beverages',
                description: 'Food items and drinks',
                product_count: 12,
                created_at: '2024-01-25'
            },
            {
                id: 4,
                name: 'Books',
                description: 'Books and reading materials',
                product_count: 3,
                created_at: '2024-02-01'
            }
        ],
        
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
                stock_quantity: 8,
                barcode: '123456789013',
                status: 'active',
                description: 'Samsung flagship phone'
            },
            {
                id: 3,
                name: 'T-Shirt Cotton',
                category_id: 2,
                price: 29.99,
                cost: 15.00,
                stock_quantity: 50,
                barcode: '123456789014',
                status: 'active',
                description: 'Comfortable cotton t-shirt'
            },
            {
                id: 4,
                name: 'Coffee Premium',
                category_id: 3,
                price: 19.99,
                cost: 12.00,
                stock_quantity: 3,
                barcode: '123456789015',
                status: 'active',
                description: 'Premium coffee beans'
            },
            {
                id: 5,
                name: 'Programming Guide',
                category_id: 4,
                price: 49.99,
                cost: 25.00,
                stock_quantity: 15,
                barcode: '123456789016',
                status: 'active',
                description: 'Complete programming guide'
            }
        ],

        supplies: [
            {
                id: 1,
                supply_id: '#SUP-001',
                product_name: 'Coffee Beans',
                product_description: 'Premium Arabica',
                supplier: 'Coffee Co.',
                quantity: '50 kg',
                cost: 450.00,
                date: 'Dec 25, 2024',
                status: 'delivered'
            },
            {
                id: 2,
                supply_id: '#SUP-002',
                product_name: 'Pastries',
                product_description: 'Assorted varieties',
                supplier: 'Bakery Fresh',
                quantity: '100 pieces',
                cost: 275.00,
                date: 'Dec 24, 2024',
                status: 'delivered'
            },
            {
                id: 3,
                supply_id: '#SUP-003',
                product_name: 'Milk',
                product_description: 'Fresh dairy',
                supplier: 'Dairy Farm',
                quantity: '20 liters',
                cost: 80.00,
                date: 'Dec 23, 2024',
                status: 'pending'
            },
            {
                id: 4,
                supply_id: '#SUP-004',
                product_name: 'Sugar',
                product_description: 'White granulated',
                supplier: 'Sweet Supply Co.',
                quantity: '25 kg',
                cost: 75.00,
                date: 'Dec 22, 2024',
                status: 'delivered'
            },
            {
                id: 5,
                supply_id: '#SUP-005',
                product_name: 'Paper Cups',
                product_description: '16oz disposable',
                supplier: 'EcoPack Ltd.',
                quantity: '1000 pieces',
                cost: 120.00,
                date: 'Dec 21, 2024',
                status: 'delivered'
            }
        ],
        
        // Computed properties
        get filteredProducts() {
            let filtered = this.products;
            
            // Search filter
            if (this.productSearchQuery) {
                filtered = filtered.filter(product => 
                    product.name.toLowerCase().includes(this.productSearchQuery.toLowerCase()) ||
                    (product.barcode && product.barcode.includes(this.productSearchQuery))
                );
            }
            
            // Category filter
            if (this.productCategoryFilter) {
                filtered = filtered.filter(product => 
                    product.category_id == this.productCategoryFilter
                );
            }
            
            // Status filter
            if (this.productStatusFilter) {
                filtered = filtered.filter(product => 
                    product.status === this.productStatusFilter
                );
            }
            
            return filtered;
        },

        get filteredSupplies() {
            let filtered = this.supplies;
            
            // Search filter
            if (this.supplySearchQuery) {
                filtered = filtered.filter(supply => 
                    supply.product_name.toLowerCase().includes(this.supplySearchQuery.toLowerCase()) ||
                    supply.supplier.toLowerCase().includes(this.supplySearchQuery.toLowerCase()) ||
                    supply.supply_id.toLowerCase().includes(this.supplySearchQuery.toLowerCase())
                );
            }
            
            // Status filter
            if (this.supplyStatusFilter) {
                filtered = filtered.filter(supply => 
                    supply.status === this.supplyStatusFilter
                );
            }
            
            // Date filter
            if (this.supplyDateFilter) {
                filtered = filtered.filter(supply => 
                    supply.date.includes(this.supplyDateFilter)
                );
            }
            
            return filtered;
        },
        
        // Methods
        getCategoryName(categoryId) {
            const category = this.categories.find(c => c.id === categoryId);
            return category ? category.name : 'Unknown';
        },
        
        openAddCategoryModal() {
            this.showAddCategoryModal = true;
            this.resetCategoryForm();
        },
        
        closeAddCategoryModal() {
            this.showAddCategoryModal = false;
            this.resetCategoryForm();
        },
        
        openAddProductModal() {
            this.showAddProductModal = true;
            this.resetProductForm();
        },
        
        closeAddProductModal() {
            this.showAddProductModal = false;
            this.resetProductForm();
        },

        openAddSupplyModal() {
            this.showAddSupplyModal = true;
            this.resetSupplyForm();
        },
        
        closeAddSupplyModal() {
            this.showAddSupplyModal = false;
            this.resetSupplyForm();
        },
        
        resetCategoryForm() {
            this.addCategoryForm = {
                name: '',
                description: '',
                loading: false
            };
        },
        
        resetProductForm() {
            this.addProductForm = {
                name: '',
                category_id: '',
                price: '',
                cost: '',
                stock_quantity: '',
                barcode: '',
                status: 'active',
                description: '',
                loading: false
            };
        },

        resetSupplyForm() {
            this.addSupplyForm = {
                id: null,
                product_name: '',
                supplier: '',
                quantity: '',
                cost: '',
                date: new Date().toISOString().split('T')[0],
                status: 'pending',
                product_description: '',
                loading: false
            };
        },
        
        addCategory() {
            if (!this.addCategoryForm.name.trim()) return;
            
            this.addCategoryForm.loading = true;
            
            // Simulate API call
            setTimeout(() => {
                const newCategory = {
                    id: this.categories.length + 1,
                    name: this.addCategoryForm.name,
                    description: this.addCategoryForm.description,
                    product_count: 0,
                    created_at: new Date().toISOString().split('T')[0]
                };
                
                this.categories.push(newCategory);
                this.closeAddCategoryModal();
                alert('Category added successfully!');
            }, 1000);
        },
        
        addProduct() {
            if (!this.addProductForm.name.trim() || !this.addProductForm.category_id) return;
            
            this.addProductForm.loading = true;
            
            // Simulate API call
            setTimeout(() => {
                const newProduct = {
                    id: this.products.length + 1,
                    name: this.addProductForm.name,
                    category_id: parseInt(this.addProductForm.category_id),
                    price: parseFloat(this.addProductForm.price),
                    cost: parseFloat(this.addProductForm.cost),
                    stock_quantity: parseInt(this.addProductForm.stock_quantity),
                    barcode: this.addProductForm.barcode,
                    status: this.addProductForm.status,
                    description: this.addProductForm.description
                };
                
                this.products.push(newProduct);
                
                // Update category product count
                const category = this.categories.find(c => c.id === newProduct.category_id);
                if (category) {
                    category.product_count++;
                }
                
                this.closeAddProductModal();
                alert('Product added successfully!');
            }, 1000);
        },

        addSupply() {
            if (!this.addSupplyForm.product_name.trim() || !this.addSupplyForm.supplier.trim()) return;
            
            this.addSupplyForm.loading = true;
            
            // Simulate API call
            setTimeout(() => {
                if (this.addSupplyForm.id) {
                    // Update existing supply
                    const index = this.supplies.findIndex(s => s.id === this.addSupplyForm.id);
                    if (index !== -1) {
                        this.supplies[index] = {
                            ...this.addSupplyForm,
                            supply_id: this.supplies[index].supply_id
                        };
                    }
                    alert('Supply updated successfully!');
                } else {
                    // Add new supply
                    const newSupply = {
                        ...this.addSupplyForm,
                        id: this.supplies.length + 1,
                        supply_id: '#SUP-' + String(this.supplies.length + 1).padStart(3, '0'),
                        cost: parseFloat(this.addSupplyForm.cost)
                    };
                    
                    this.supplies.push(newSupply);
                    alert('Supply added successfully!');
                }
                
                this.closeAddSupplyModal();
            }, 1000);
        },

        editSupply(supply) {
            this.addSupplyForm = { ...supply };
            this.showAddSupplyModal = true;
        },
        
        deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
                this.categories = this.categories.filter(c => c.id !== categoryId);
                // Also update any products that had this category
                this.products = this.products.filter(p => p.category_id !== categoryId);
                alert('Category deleted successfully!');
            }
        },
        
        deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                const product = this.products.find(p => p.id === productId);
                if (product) {
                    // Update category product count
                    const category = this.categories.find(c => c.id === product.category_id);
                    if (category) {
                        category.product_count--;
                    }
                }
                
                this.products = this.products.filter(p => p.id !== productId);
                alert('Product deleted successfully!');
            }
        },

        deleteSupply(supplyId) {
            if (confirm('Are you sure you want to delete this supply?')) {
                this.supplies = this.supplies.filter(s => s.id !== supplyId);
                alert('Supply deleted successfully!');
            }
        }
    }
}
</script>
@endsection