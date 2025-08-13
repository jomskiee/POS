@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'Purchase Orders']
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
        <main class="flex-1 overflow-auto p-6" x-data="purchaseOrderManagement()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Purchase Orders Management</h1>
                            <p class="text-gray-600 mt-2">Create, track, and manage purchase orders with vendor comparison</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button @click="openVendorComparisonModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span>Compare Vendors</span>
                            </button>
                            <button @click="openCreatePOModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Create PO</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'orders'" 
                                    :class="activeTab === 'orders' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    <span>Purchase Orders</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'receiving'" 
                                    :class="activeTab === 'receiving' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <span>Receiving Goods</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'quality'" 
                                    :class="activeTab === 'quality' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    <span>Quality Control</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Purchase Orders Tab -->
                <div x-show="activeTab === 'orders'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <!-- PO Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total POs</p>
                                    <p class="text-2xl font-bold text-gray-900">145</p>
                                    <p class="text-xs text-blue-600">This month</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Pending</p>
                                    <p class="text-2xl font-bold text-gray-900">23</p>
                                    <p class="text-xs text-yellow-600">Awaiting approval</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Approved</p>
                                    <p class="text-2xl font-bold text-gray-900">98</p>
                                    <p class="text-xs text-green-600">Ready to order</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Value</p>
                                    <p class="text-2xl font-bold text-gray-900">$24,680</p>
                                    <p class="text-xs text-purple-600">Outstanding</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Orders Table -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Purchase Orders</h3>
                                <div class="flex space-x-3">
                                    <select class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option>All Status</option>
                                        <option>Draft</option>
                                        <option>Pending</option>
                                        <option>Approved</option>
                                        <option>Ordered</option>
                                        <option>Received</option>
                                    </select>
                                    <input type="text" placeholder="Search POs..." 
                                           class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PO Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" x-data="{ 
                                    purchaseOrders: [
                                        {
                                            id: 1,
                                            po_number: 'PO-2024-001',
                                            vendor: 'ABC Supplies Co.',
                                            items: 15,
                                            total: 2450.75,
                                            date: '2024-12-26',
                                            status: 'approved'
                                        },
                                        {
                                            id: 2,
                                            po_number: 'PO-2024-002',
                                            vendor: 'Tech Equipment Ltd.',
                                            items: 8,
                                            total: 5680.30,
                                            date: '2024-12-25',
                                            status: 'pending'
                                        },
                                        {
                                            id: 3,
                                            po_number: 'PO-2024-003',
                                            vendor: 'Office Supplies Inc.',
                                            items: 23,
                                            total: 1245.50,
                                            date: '2024-12-24',
                                            status: 'ordered'
                                        }
                                    ]
                                }">
                                    <template x-for="po in purchaseOrders" :key="po.id">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-blue-600" x-text="po.po_number"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="po.vendor"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="po.items + ' items'"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900" x-text="'$' + po.total.toFixed(2)"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="po.date"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                      :class="{
                                                          'bg-green-100 text-green-800': po.status === 'approved',
                                                          'bg-yellow-100 text-yellow-800': po.status === 'pending',
                                                          'bg-blue-100 text-blue-800': po.status === 'ordered',
                                                          'bg-purple-100 text-purple-800': po.status === 'received'
                                                      }"
                                                      x-text="po.status.charAt(0).toUpperCase() + po.status.slice(1)"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="alert('View PO: ' + po.po_number)"
                                                            class="text-blue-600 hover:text-blue-900 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </button>
                                                    <button @click="alert('Edit PO: ' + po.po_number)"
                                                            class="text-green-600 hover:text-green-900 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
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

                <!-- Receiving Goods Tab -->
                <div x-show="activeTab === 'receiving'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
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
                </div>

                <!-- Quality Control Tab -->
                <div x-show="activeTab === 'quality'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Quality Checklist Template -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quality Control Checklist</h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <label class="text-sm text-gray-700">Physical condition inspection</label>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <label class="text-sm text-gray-700">Quantity verification</label>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <label class="text-sm text-gray-700">Packaging integrity check</label>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <label class="text-sm text-gray-700">Documentation review</label>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <label class="text-sm text-gray-700">Expiry date verification</label>
                                </div>
                                
                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quality Notes</label>
                                    <textarea rows="4" 
                                              placeholder="Enter quality control observations..."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <button class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        Approve
                                    </button>
                                    <button class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                        Reject
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quality Control History -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Quality Checks</h3>
                            <div class="space-y-4">
                                <div class="border-l-4 border-green-500 pl-4 py-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">PO-2024-001</p>
                                            <p class="text-xs text-gray-600">Coffee Beans Premium - 50 units</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Dec 26, 2024 - 14:30</p>
                                </div>

                                <div class="border-l-4 border-red-500 pl-4 py-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">PO-2024-002</p>
                                            <p class="text-xs text-gray-600">Electronics Components - 25 units</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Dec 26, 2024 - 12:15</p>
                                    <p class="text-xs text-red-600 mt-1">Reason: Damaged packaging</p>
                                </div>

                                <div class="border-l-4 border-yellow-500 pl-4 py-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">PO-2024-003</p>
                                            <p class="text-xs text-gray-600">Office Supplies - 100 units</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Dec 26, 2024 - 10:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create PO Modal -->
            <div x-show="showCreatePOModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeCreatePOModal()">
                <div class="relative top-10 mx-auto p-5 border w-3/4 max-w-4xl shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Create Purchase Order</h3>
                        <button @click="closeCreatePOModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="createPO()">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Vendor</label>
                                <select required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Vendor</option>
                                    <option value="1">ABC Supplies Co.</option>
                                    <option value="2">Tech Equipment Ltd.</option>
                                    <option value="3">Office Supplies Inc.</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expected Delivery</label>
                                <input type="date" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Items</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-center text-gray-500">Add items to this purchase order</p>
                                <button type="button" class="mt-2 mx-auto block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Add Items
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" 
                                    @click="closeCreatePOModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                                Create Purchase Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Vendor Comparison Modal -->
            <div x-show="showVendorModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeVendorModal()">
                <div class="relative top-10 mx-auto p-5 border w-3/4 max-w-5xl shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Vendor Comparison Tool</h3>
                        <button @click="closeVendorModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Vendor A -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">ABC Supplies Co.</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Price:</span>
                                    <span class="font-medium">$1,245.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Delivery:</span>
                                    <span class="font-medium">3-5 days</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Rating:</span>
                                    <span class="font-medium text-yellow-600">★★★★☆ 4.2</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Terms:</span>
                                    <span class="font-medium">Net 30</span>
                                </div>
                            </div>
                        </div>

                        <!-- Vendor B -->
                        <div class="border border-blue-200 bg-blue-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-semibold text-gray-900">Tech Equipment Ltd.</h4>
                                <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full">Best Value</span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Price:</span>
                                    <span class="font-medium text-green-600">$1,180.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Delivery:</span>
                                    <span class="font-medium">2-4 days</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Rating:</span>
                                    <span class="font-medium text-yellow-600">★★★★★ 4.8</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Terms:</span>
                                    <span class="font-medium">Net 15</span>
                                </div>
                            </div>
                        </div>

                        <!-- Vendor C -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Office Supplies Inc.</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Price:</span>
                                    <span class="font-medium">$1,320.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Delivery:</span>
                                    <span class="font-medium">1-2 days</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Rating:</span>
                                    <span class="font-medium text-yellow-600">★★★☆☆ 3.9</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Terms:</span>
                                    <span class="font-medium">Net 45</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-center mt-6">
                        <button @click="closeVendorModal()"
                                class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                            Select Tech Equipment Ltd.
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function purchaseOrderManagement() {
    return {
        activeTab: 'orders',
        showCreatePOModal: false,
        showVendorModal: false,
        
        openCreatePOModal() {
            this.showCreatePOModal = true;
        },
        
        closeCreatePOModal() {
            this.showCreatePOModal = false;
        },
        
        openVendorComparisonModal() {
            this.showVendorModal = true;
        },
        
        closeVendorModal() {
            this.showVendorModal = false;
        },
        
        createPO() {
            alert('Purchase Order created successfully!');
            this.closeCreatePOModal();
        }
    }
}
</script>
@endsection