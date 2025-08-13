@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-white min-h-screen shadow-lg transition-all duration-300 ease-in-out overflow-hidden">
        <div class="p-4 border-b">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-sm">POS</span>
                </div>
                <span x-show="sidebarOpen" x-transition class="text-xl font-bold text-gray-800 whitespace-nowrap">Point of Sale</span>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-6">
            <div x-show="sidebarOpen" x-transition class="px-4 pb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</p>
            </div>
            
            <ul class="space-y-1 px-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Dashboard</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 715 0z"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">User Management</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-blue-600 bg-blue-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Product Management</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('pos.terminal') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">POS Terminal</span>
                    </a>
                </li>
                
                <li>
                    <a href="#" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Reports</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- Breadcrumbs -->
                    <nav class="text-sm">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Admin</a>
                            </li>
                            <li>
                                <span class="text-gray-300">/</span>
                            </li>
                            <li>
                                <span class="text-gray-900">Product Management</span>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- POS Terminal Button - Hidden on mobile, visible on md+ screens -->
                    <a href="{{ route('pos.terminal') }}" class="hidden md:inline-flex bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                        POS Terminal
                    </a>
                    
                    <!-- Notifications -->
                    <button class="text-gray-500 hover:text-gray-700 relative transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-6h4v6z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-sm text-gray-700 hover:text-gray-900 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <div class="py-1">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <div class="font-medium">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6" x-data="productManagement()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Product Management</h1>
                            <p class="text-gray-600 mt-2">Manage product categories and inventory</p>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
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
                        </nav>
                    </div>
                </div>

                <!-- Categories Tab Content -->
                <div x-show="activeTab === 'categories'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
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
                                        <button @click="openEditCategoryModal(category)" 
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
                </div>

                <!-- Products Tab Content -->
                <div x-show="activeTab === 'products'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Product Inventory</h2>
                        <button @click="openAddProductModal()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
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
                                           x-model="productSearchQuery"
                                           placeholder="Search products..." 
                                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <select x-model="productCategoryFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Categories</option>
                                <template x-for="category in categories" :key="category.id">
                                    <option :value="category.id" x-text="category.name"></option>
                                </template>
                            </select>
                            <select x-model="productStatusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                <tbody class="divide-y divide-gray-200">
                                    <template x-for="product in filteredProducts" :key="product.id">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
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
                                                     :class="product.stock_quantity <= 5 ? 'text-red-600' : product.stock_quantity <= 10 ? 'text-yellow-600' : 'text-green-600'"
                                                     x-text="product.stock_quantity + ' units'"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                      :class="product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                      x-text="product.status.charAt(0).toUpperCase() + product.status.slice(1)"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="openEditProductModal(product)" 
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
        </main>
    </div>
</div>

<script>
function productManagement() {
    return {
        // State
        activeTab: 'categories',
        showAddCategoryModal: false,
        showAddProductModal: false,
        productSearchQuery: '',
        productCategoryFilter: '',
        productStatusFilter: '',
        
        // Dummy categories data
        categories: [
            {
                id: 1,
                name: 'Electronics',
                description: 'Electronic devices and accessories',
                product_count: 15,
                created_at: '2024-01-15'
            },
            {
                id: 2,
                name: 'Clothing',
                description: 'Apparel and fashion items',
                product_count: 23,
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
                name: 'Home & Garden',
                description: 'Home improvement and garden supplies',
                product_count: 12,
                created_at: '2024-02-10'
            }
        ],
        
        // Dummy products data
        products: [
            {
                id: 1,
                name: 'iPhone 15 Pro',
                description: 'Latest iPhone with advanced camera system',
                category_id: 1,
                price: 999.00,
                cost: 750.00,
                stock_quantity: 25,
                barcode: '123456789012',
                status: 'active',
                created_at: '2024-03-01'
            },
            {
                id: 2,
                name: 'Samsung Galaxy S24',
                description: 'High-end Android smartphone',
                category_id: 1,
                price: 899.00,
                cost: 650.00,
                stock_quantity: 18,
                barcode: '123456789013',
                status: 'active',
                created_at: '2024-03-05'
            },
            {
                id: 3,
                name: 'Nike Air Max',
                description: 'Comfortable running shoes',
                category_id: 2,
                price: 150.00,
                cost: 90.00,
                stock_quantity: 3,
                barcode: '123456789014',
                status: 'active',
                created_at: '2024-03-10'
            },
            {
                id: 4,
                name: 'Coffee Beans',
                description: 'Premium arabica coffee beans',
                category_id: 3,
                price: 25.00,
                cost: 15.00,
                stock_quantity: 50,
                barcode: '123456789015',
                status: 'active',
                created_at: '2024-03-12'
            },
            {
                id: 5,
                name: 'Garden Hose',
                description: '50ft expandable garden hose',
                category_id: 4,
                price: 45.00,
                cost: 25.00,
                stock_quantity: 8,
                barcode: '123456789016',
                status: 'inactive',
                created_at: '2024-03-15'
            }
        ],
        
        // Form data
        addCategoryForm: {
            name: '',
            description: '',
            loading: false
        },
        
        addProductForm: {
            name: '',
            description: '',
            category_id: '',
            price: '',
            cost: '',
            stock_quantity: '',
            barcode: '',
            status: 'active',
            loading: false
        },
        
        // Computed
        get filteredProducts() {
            let filtered = this.products;
            
            // Filter by search query
            if (this.productSearchQuery) {
                const query = this.productSearchQuery.toLowerCase();
                filtered = filtered.filter(product => 
                    product.name.toLowerCase().includes(query) || 
                    product.barcode?.toLowerCase().includes(query)
                );
            }
            
            // Filter by category
            if (this.productCategoryFilter) {
                filtered = filtered.filter(product => product.category_id == this.productCategoryFilter);
            }
            
            // Filter by status
            if (this.productStatusFilter) {
                filtered = filtered.filter(product => product.status === this.productStatusFilter);
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
            this.resetAddCategoryForm();
        },
        
        closeAddCategoryModal() {
            this.showAddCategoryModal = false;
            this.resetAddCategoryForm();
        },
        
        openAddProductModal() {
            this.showAddProductModal = true;
            this.resetAddProductForm();
        },
        
        closeAddProductModal() {
            this.showAddProductModal = false;
            this.resetAddProductForm();
        },
        
        resetAddCategoryForm() {
            this.addCategoryForm = {
                name: '',
                description: '',
                loading: false
            };
        },
        
        resetAddProductForm() {
            this.addProductForm = {
                name: '',
                description: '',
                category_id: '',
                price: '',
                cost: '',
                stock_quantity: '',
                barcode: '',
                status: 'active',
                loading: false
            };
        },
        
        async addCategory() {
            this.addCategoryForm.loading = true;
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Add to dummy data
                const newCategory = {
                    id: this.categories.length + 1,
                    name: this.addCategoryForm.name,
                    description: this.addCategoryForm.description,
                    product_count: 0,
                    created_at: new Date().toISOString()
                };
                
                this.categories.push(newCategory);
                this.closeAddCategoryModal();
                alert('Category added successfully!');
                
            } catch (error) {
                console.error('Error adding category:', error);
                alert('Failed to add category. Please try again.');
            } finally {
                this.addCategoryForm.loading = false;
            }
        },
        
        async addProduct() {
            this.addProductForm.loading = true;
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Add to dummy data
                const newProduct = {
                    id: this.products.length + 1,
                    name: this.addProductForm.name,
                    description: this.addProductForm.description,
                    category_id: parseInt(this.addProductForm.category_id),
                    price: parseFloat(this.addProductForm.price),
                    cost: parseFloat(this.addProductForm.cost),
                    stock_quantity: parseInt(this.addProductForm.stock_quantity),
                    barcode: this.addProductForm.barcode,
                    status: this.addProductForm.status,
                    created_at: new Date().toISOString()
                };
                
                this.products.push(newProduct);
                
                // Update category product count
                const category = this.categories.find(c => c.id === newProduct.category_id);
                if (category) {
                    category.product_count++;
                }
                
                this.closeAddProductModal();
                alert('Product added successfully!');
                
            } catch (error) {
                console.error('Error adding product:', error);
                alert('Failed to add product. Please try again.');
            } finally {
                this.addProductForm.loading = false;
            }
        },
        
        async deleteCategory(categoryId) {
            if (!confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                return;
            }
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // Remove from dummy data
                this.categories = this.categories.filter(c => c.id !== categoryId);
                alert('Category deleted successfully!');
                
            } catch (error) {
                console.error('Error deleting category:', error);
                alert('Failed to delete category. Please try again.');
            }
        },
        
        async deleteProduct(productId) {
            if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                return;
            }
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // Find product to get category_id before deletion
                const product = this.products.find(p => p.id === productId);
                if (product) {
                    // Update category product count
                    const category = this.categories.find(c => c.id === product.category_id);
                    if (category) {
                        category.product_count--;
                    }
                }
                
                // Remove from dummy data
                this.products = this.products.filter(p => p.id !== productId);
                alert('Product deleted successfully!');
                
            } catch (error) {
                console.error('Error deleting product:', error);
                alert('Failed to delete product. Please try again.');
            }
        }
    }
}
</script>
@endsection