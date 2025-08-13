@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'Digital Integration']
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
        <main class="flex-1 overflow-auto p-6" x-data="digitalIntegration()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Digital Integration</h1>
                            <p class="text-gray-600 mt-2">Modern POS features with QR codes, digital receipts, social media, and online store sync</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button @click="generateQRCodes()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5v5H4V4zm11 11h5v5h-5v-5zM4 15h5v5H4v-5z"></path>
                                </svg>
                                <span>Generate QR Codes</span>
                            </button>
                            <button @click="syncOnlineStore()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Sync Online Store</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'qr-codes'" 
                                    :class="activeTab === 'qr-codes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5v5H4V4zm11 11h5v5h-5v-5zM4 15h5v5H4v-5z"></path>
                                    </svg>
                                    <span>QR Code Generation</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'digital-receipts'" 
                                    :class="activeTab === 'digital-receipts' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Digital Receipts</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'social-media'" 
                                    :class="activeTab === 'social-media' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m3 0a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h3z"></path>
                                    </svg>
                                    <span>Social Media Integration</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'reviews'" 
                                    :class="activeTab === 'reviews' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span>Review Management</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'online-store'" 
                                    :class="activeTab === 'online-store' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span>Online Store Sync</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="space-y-6">
                    <!-- QR Code Generation Tab -->
                    <div x-show="activeTab === 'qr-codes'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- QR Code Generator -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code Generator</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">QR Code Type</label>
                                        <select x-model="qrGenerator.type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="product">Product Information</option>
                                            <option value="menu">Digital Menu</option>
                                            <option value="wifi">WiFi Access</option>
                                            <option value="payment">Payment Link</option>
                                            <option value="review">Review Request</option>
                                            <option value="contact">Contact Info</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Product QR -->
                                    <div x-show="qrGenerator.type === 'product'">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Product</label>
                                        <select x-model="qrGenerator.productId" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Choose Product...</option>
                                            <template x-for="product in products" :key="product.id">
                                                <option :value="product.id" x-text="product.name + ' - $' + product.price"></option>
                                            </template>
                                        </select>
                                    </div>
                                    
                                    <!-- WiFi QR -->
                                    <div x-show="qrGenerator.type === 'wifi'" class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">WiFi Network Name</label>
                                            <input type="text" x-model="qrGenerator.wifiSSID" placeholder="Store_WiFi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                            <input type="text" x-model="qrGenerator.wifiPassword" placeholder="password123" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    
                                    <!-- Payment QR -->
                                    <div x-show="qrGenerator.type === 'payment'" class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                            <select x-model="qrGenerator.paymentMethod" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="paypal">PayPal</option>
                                                <option value="stripe">Stripe</option>
                                                <option value="venmo">Venmo</option>
                                                <option value="cashapp">Cash App</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount (Optional)</label>
                                            <input type="number" x-model="qrGenerator.amount" step="0.01" placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4">
                                        <button @click="generateQR()" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            Generate QR Code
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- QR Code Preview -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code Preview</h3>
                                <div class="text-center">
                                    <div class="w-48 h-48 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg mx-auto flex items-center justify-center mb-4">
                                        <div x-show="!qrGenerator.generated" class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5v5H4V4zm11 11h5v5h-5v-5zM4 15h5v5H4v-5z"></path>
                                            </svg>
                                            <p class="text-gray-500 text-sm">QR Code will appear here</p>
                                        </div>
                                        <div x-show="qrGenerator.generated" class="bg-black w-40 h-40 rounded flex items-center justify-center">
                                            <div class="grid grid-cols-8 gap-1 p-2">
                                                <template x-for="i in 64" :key="i">
                                                    <div class="w-2 h-2" :class="Math.random() > 0.5 ? 'bg-white' : 'bg-black'"></div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div x-show="qrGenerator.generated" class="space-y-3">
                                        <p class="text-sm text-gray-600" x-text="qrGenerator.description"></p>
                                        <div class="flex space-x-2">
                                            <button @click="downloadQR()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                                Download
                                            </button>
                                            <button @click="printQR()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                                Print
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Generated QR Codes History -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent QR Codes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <template x-for="qr in qrHistory" :key="qr.id">
                                    <div class="border border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                                        <div class="w-16 h-16 bg-gray-800 rounded mx-auto mb-2 flex items-center justify-center">
                                            <span class="text-white text-xs">QR</span>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900" x-text="qr.name"></p>
                                        <p class="text-xs text-gray-500" x-text="qr.type"></p>
                                        <p class="text-xs text-gray-400" x-text="qr.created"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Digital Receipts Tab -->
                    <div x-show="activeTab === 'digital-receipts'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Digital Receipt Settings -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Digital Receipt Options</h3>
                                <div class="space-y-4">
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="digitalReceipts.enableEmail" id="enable-email" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="enable-email" class="ml-2 text-sm text-gray-700">Email Receipts</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="digitalReceipts.enableSMS" id="enable-sms" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="enable-sms" class="ml-2 text-sm text-gray-700">SMS Receipts</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="digitalReceipts.enableQR" id="enable-qr-receipt" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="enable-qr-receipt" class="ml-2 text-sm text-gray-700">QR Code Access</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="digitalReceipts.enablePDF" id="enable-pdf" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="enable-pdf" class="ml-2 text-sm text-gray-700">PDF Download</label>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Default Delivery Method</label>
                                        <select x-model="digitalReceipts.defaultMethod" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="email">Email</option>
                                            <option value="sms">SMS</option>
                                            <option value="both">Both Email & SMS</option>
                                            <option value="qr">QR Code Only</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Template</label>
                                        <select x-model="digitalReceipts.emailTemplate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="modern">Modern Template</option>
                                            <option value="classic">Classic Template</option>
                                            <option value="minimal">Minimal Template</option>
                                            <option value="branded">Branded Template</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Receipt Storage</label>
                                        <select x-model="digitalReceipts.storage" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="30">30 days</option>
                                            <option value="90">90 days</option>
                                            <option value="365">1 year</option>
                                            <option value="forever">Forever</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Digital Receipt Statistics -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Digital Receipt Analytics</h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                                            <div class="text-2xl font-bold text-blue-600">1,234</div>
                                            <div class="text-sm text-blue-700">Email Receipts Sent</div>
                                        </div>
                                        <div class="text-center p-4 bg-green-50 rounded-lg">
                                            <div class="text-2xl font-bold text-green-600">567</div>
                                            <div class="text-sm text-green-700">SMS Receipts Sent</div>
                                        </div>
                                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                                            <div class="text-2xl font-bold text-purple-600">89%</div>
                                            <div class="text-sm text-purple-700">Open Rate</div>
                                        </div>
                                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                            <div class="text-2xl font-bold text-yellow-600">234</div>
                                            <div class="text-sm text-yellow-700">QR Scans</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Recent Digital Receipts</h4>
                                        <div class="space-y-2">
                                            <template x-for="receipt in digitalReceipts.recent" :key="receipt.id">
                                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900" x-text="receipt.customer"></div>
                                                        <div class="text-xs text-gray-500" x-text="receipt.date + ' • $' + receipt.amount"></div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                              :class="{
                                                                  'bg-green-100 text-green-800': receipt.method === 'email',
                                                                  'bg-blue-100 text-blue-800': receipt.method === 'sms',
                                                                  'bg-purple-100 text-purple-800': receipt.method === 'qr'
                                                              }"
                                                              x-text="receipt.method.toUpperCase()"></span>
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                              :class="{
                                                                  'bg-green-100 text-green-800': receipt.status === 'delivered',
                                                                  'bg-yellow-100 text-yellow-800': receipt.status === 'pending',
                                                                  'bg-red-100 text-red-800': receipt.status === 'failed'
                                                              }"
                                                              x-text="receipt.status.charAt(0).toUpperCase() + receipt.status.slice(1)"></span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Integration Tab -->
                    <div x-show="activeTab === 'social-media'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Social Media Connections -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Connected Accounts</h3>
                                <div class="space-y-4">
                                    <template x-for="platform in socialMedia.platforms" :key="platform.name">
                                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                                     :class="{
                                                         'bg-blue-100': platform.name === 'Facebook',
                                                         'bg-blue-400': platform.name === 'Twitter',
                                                         'bg-pink-100': platform.name === 'Instagram',
                                                         'bg-red-100': platform.name === 'YouTube',
                                                         'bg-indigo-100': platform.name === 'TikTok'
                                                     }">
                                                    <span class="text-sm font-semibold"
                                                          :class="{
                                                              'text-blue-600': platform.name === 'Facebook',
                                                              'text-white': platform.name === 'Twitter',
                                                              'text-pink-600': platform.name === 'Instagram',
                                                              'text-red-600': platform.name === 'YouTube',
                                                              'text-indigo-600': platform.name === 'TikTok'
                                                          }"
                                                          x-text="platform.name.charAt(0)"></span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900" x-text="platform.name"></div>
                                                    <div class="text-xs text-gray-500" x-text="platform.connected ? '@' + platform.username : 'Not connected'"></div>
                                                </div>
                                            </div>
                                            <button @click="toggleConnection(platform)"
                                                    :class="platform.connected ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700'"
                                                    class="px-3 py-1 text-white text-sm rounded-lg transition-colors"
                                                    x-text="platform.connected ? 'Disconnect' : 'Connect'">
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Auto-Post Settings</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="socialMedia.autoPost.newProducts" id="auto-post-products" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="auto-post-products" class="ml-2 text-sm text-gray-700">Auto-post new products</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="socialMedia.autoPost.promotions" id="auto-post-promotions" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="auto-post-promotions" class="ml-2 text-sm text-gray-700">Auto-post promotions</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="socialMedia.autoPost.milestones" id="auto-post-milestones" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="auto-post-milestones" class="ml-2 text-sm text-gray-700">Auto-post sales milestones</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Analytics -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Media Performance</h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                                            <div class="text-2xl font-bold text-blue-600">2.5K</div>
                                            <div class="text-sm text-blue-700">Total Followers</div>
                                        </div>
                                        <div class="text-center p-4 bg-green-50 rounded-lg">
                                            <div class="text-2xl font-bold text-green-600">156</div>
                                            <div class="text-sm text-green-700">Posts This Month</div>
                                        </div>
                                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                                            <div class="text-2xl font-bold text-purple-600">4.2%</div>
                                            <div class="text-sm text-purple-700">Engagement Rate</div>
                                        </div>
                                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                            <div class="text-2xl font-bold text-yellow-600">89</div>
                                            <div class="text-sm text-yellow-700">Store Visits</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Recent Activity</h4>
                                        <div class="space-y-3">
                                            <template x-for="activity in socialMedia.recentActivity" :key="activity.id">
                                                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold text-white"
                                                         :class="{
                                                             'bg-blue-500': activity.platform === 'Facebook',
                                                             'bg-blue-400': activity.platform === 'Twitter',
                                                             'bg-pink-500': activity.platform === 'Instagram',
                                                             'bg-red-500': activity.platform === 'YouTube'
                                                         }"
                                                         x-text="activity.platform.charAt(0)"></div>
                                                    <div class="flex-1">
                                                        <div class="text-sm text-gray-900" x-text="activity.action"></div>
                                                        <div class="text-xs text-gray-500" x-text="activity.time"></div>
                                                    </div>
                                                    <div class="text-sm text-gray-600" x-text="activity.engagement"></div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Management Tab -->
                    <div x-show="activeTab === 'reviews'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Review Overview -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Overview</h3>
                                <div class="space-y-4">
                                    <div class="text-center p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl">
                                        <div class="text-4xl font-bold text-yellow-600">4.8</div>
                                        <div class="flex justify-center my-2">
                                            <template x-for="i in 5" :key="i">
                                                <svg class="w-5 h-5" :class="i <= 4 ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            </template>
                                        </div>
                                        <div class="text-sm text-yellow-700">Based on 284 reviews</div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <template x-for="rating in reviews.distribution" :key="rating.stars">
                                            <div class="flex items-center">
                                                <span class="text-sm text-gray-600 w-6" x-text="rating.stars"></span>
                                                <svg class="w-4 h-4 text-yellow-400 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                <div class="ml-2 flex-1 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-yellow-400 h-2 rounded-full" :style="'width: ' + rating.percentage + '%'"></div>
                                                </div>
                                                <span class="ml-2 text-sm text-gray-600" x-text="rating.count"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Management Tools -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Management</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Auto-Request Reviews</label>
                                        <select x-model="reviews.autoRequest" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="disabled">Disabled</option>
                                            <option value="immediate">Immediately after purchase</option>
                                            <option value="1day">1 day after purchase</option>
                                            <option value="3days">3 days after purchase</option>
                                            <option value="1week">1 week after purchase</option>
                                        </select>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="reviews.settings.emailRequests" id="email-requests" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="email-requests" class="ml-2 text-sm text-gray-700">Send email review requests</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="reviews.settings.smsRequests" id="sms-requests" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="sms-requests" class="ml-2 text-sm text-gray-700">Send SMS review requests</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="reviews.settings.qrOnReceipt" id="qr-receipt" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="qr-receipt" class="ml-2 text-sm text-gray-700">Add review QR code to receipts</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="reviews.settings.autoRespond" id="auto-respond" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="auto-respond" class="ml-2 text-sm text-gray-700">Auto-respond to reviews</label>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 space-y-2">
                                        <button @click="generateReviewQR()" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                            Generate Review QR Code
                                        </button>
                                        <button @click="exportReviews()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                            Export All Reviews
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Reviews -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Reviews</h3>
                            <div class="space-y-4">
                                <template x-for="review in reviews.recent" :key="review.id">
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <div class="flex">
                                                        <template x-for="i in 5" :key="i">
                                                            <svg class="w-4 h-4" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                        </template>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-900" x-text="review.customer"></span>
                                                    <span class="text-xs text-gray-500" x-text="review.date"></span>
                                                </div>
                                                <p class="text-sm text-gray-700" x-text="review.comment"></p>
                                                <div x-show="review.response" class="mt-3 p-3 bg-blue-50 rounded-lg">
                                                    <p class="text-sm text-blue-900"><strong>Your Response:</strong> <span x-text="review.response"></span></p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2 ml-4">
                                                <button @click="respondToReview(review.id)" class="text-blue-600 hover:text-blue-800 text-sm">
                                                    <span x-text="review.response ? 'Edit' : 'Respond'"></span>
                                                </button>
                                                <button @click="hideReview(review.id)" class="text-red-600 hover:text-red-800 text-sm">
                                                    Hide
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Online Store Sync Tab -->
                    <div x-show="activeTab === 'online-store'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Platform Connections -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">E-commerce Platforms</h3>
                                <div class="space-y-4">
                                    <template x-for="platform in onlineStore.platforms" :key="platform.name">
                                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-lg flex items-center justify-center"
                                                     :class="{
                                                         'bg-orange-100': platform.name === 'Shopify',
                                                         'bg-blue-100': platform.name === 'WooCommerce',
                                                         'bg-yellow-100': platform.name === 'Amazon',
                                                         'bg-red-100': platform.name === 'eBay',
                                                         'bg-green-100': platform.name === 'Etsy'
                                                     }">
                                                    <span class="text-lg font-bold"
                                                          :class="{
                                                              'text-orange-600': platform.name === 'Shopify',
                                                              'text-blue-600': platform.name === 'WooCommerce',
                                                              'text-yellow-600': platform.name === 'Amazon',
                                                              'text-red-600': platform.name === 'eBay',
                                                              'text-green-600': platform.name === 'Etsy'
                                                          }"
                                                          x-text="platform.name.charAt(0)"></span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900" x-text="platform.name"></div>
                                                    <div class="text-xs text-gray-500" x-text="platform.connected ? 'Connected • ' + platform.products + ' products' : 'Not connected'"></div>
                                                    <div x-show="platform.connected" class="text-xs text-green-600" x-text="'Last sync: ' + platform.lastSync"></div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button x-show="platform.connected" @click="syncPlatform(platform)" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors">
                                                    Sync
                                                </button>
                                                <button @click="togglePlatformConnection(platform)"
                                                        :class="platform.connected ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                                        class="px-3 py-1 text-white text-sm rounded-lg transition-colors"
                                                        x-text="platform.connected ? 'Disconnect' : 'Connect'">
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Sync Settings</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="onlineStore.syncSettings.autoSync" id="auto-sync" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="auto-sync" class="ml-2 text-sm text-gray-700">Auto-sync every hour</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="onlineStore.syncSettings.syncInventory" id="sync-inventory" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="sync-inventory" class="ml-2 text-sm text-gray-700">Sync inventory levels</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="onlineStore.syncSettings.syncPrices" id="sync-prices" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="sync-prices" class="ml-2 text-sm text-gray-700">Sync product prices</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" x-model="onlineStore.syncSettings.syncOrders" id="sync-orders" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="sync-orders" class="ml-2 text-sm text-gray-700">Import online orders</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sync Status & Analytics -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sync Analytics</h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center p-4 bg-green-50 rounded-lg">
                                            <div class="text-2xl font-bold text-green-600">1,247</div>
                                            <div class="text-sm text-green-700">Products Synced</div>
                                        </div>
                                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                                            <div class="text-2xl font-bold text-blue-600">89</div>
                                            <div class="text-sm text-blue-700">Orders Imported</div>
                                        </div>
                                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                                            <div class="text-2xl font-bold text-purple-600">98%</div>
                                            <div class="text-sm text-purple-700">Sync Success Rate</div>
                                        </div>
                                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                            <div class="text-2xl font-bold text-yellow-600">2</div>
                                            <div class="text-sm text-yellow-700">Sync Errors</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Recent Sync Activity</h4>
                                        <div class="space-y-3">
                                            <template x-for="activity in onlineStore.recentSync" :key="activity.id">
                                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold"
                                                             :class="{
                                                                 'bg-green-100 text-green-600': activity.status === 'success',
                                                                 'bg-yellow-100 text-yellow-600': activity.status === 'warning',
                                                                 'bg-red-100 text-red-600': activity.status === 'error'
                                                             }">
                                                            <svg x-show="activity.status === 'success'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            <svg x-show="activity.status === 'warning'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                            </svg>
                                                            <svg x-show="activity.status === 'error'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="ml-3">
                                                            <div class="text-sm text-gray-900" x-text="activity.action"></div>
                                                            <div class="text-xs text-gray-500" x-text="activity.time"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm text-gray-600" x-text="activity.details"></div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 space-y-2">
                                        <button @click="manualSync()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                            Manual Sync All
                                        </button>
                                        <button @click="viewSyncLogs()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                            View Sync Logs
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function digitalIntegration() {
    return {
        activeTab: 'qr-codes',
        
        products: [
            { id: 1, name: 'iPhone 15 Pro', price: 999.99 },
            { id: 2, name: 'Samsung Galaxy S24', price: 899.99 },
            { id: 3, name: 'MacBook Pro 16', price: 2499.99 },
            { id: 4, name: 'Nike Air Max', price: 129.99 },
            { id: 5, name: 'Coffee Beans Premium', price: 24.99 }
        ],
        
        qrGenerator: {
            type: 'product',
            productId: '',
            wifiSSID: 'Store_WiFi',
            wifiPassword: 'password123',
            paymentMethod: 'paypal',
            amount: '',
            generated: false,
            description: ''
        },
        
        qrHistory: [
            { id: 1, name: 'iPhone 15 Pro', type: 'Product', created: '2 hours ago' },
            { id: 2, name: 'Store WiFi', type: 'WiFi Access', created: '1 day ago' },
            { id: 3, name: 'Payment Link', type: 'Payment', created: '2 days ago' },
            { id: 4, name: 'Digital Menu', type: 'Menu', created: '3 days ago' }
        ],
        
        digitalReceipts: {
            enableEmail: true,
            enableSMS: false,
            enableQR: true,
            enablePDF: true,
            defaultMethod: 'email',
            emailTemplate: 'modern',
            storage: '365',
            recent: [
                { id: 1, customer: 'John Doe', date: 'Dec 26, 2024', amount: '47.85', method: 'email', status: 'delivered' },
                { id: 2, customer: 'Sarah Wilson', date: 'Dec 26, 2024', amount: '15.50', method: 'sms', status: 'delivered' },
                { id: 3, customer: 'Mike Johnson', date: 'Dec 26, 2024', amount: '89.20', method: 'qr', status: 'pending' },
                { id: 4, customer: 'Emma Davis', date: 'Dec 25, 2024', amount: '23.75', method: 'email', status: 'failed' }
            ]
        },
        
        socialMedia: {
            platforms: [
                { name: 'Facebook', connected: true, username: 'yourstore' },
                { name: 'Twitter', connected: false, username: '' },
                { name: 'Instagram', connected: true, username: 'yourstore_official' },
                { name: 'YouTube', connected: false, username: '' },
                { name: 'TikTok', connected: true, username: 'yourstore_tiktok' }
            ],
            autoPost: {
                newProducts: true,
                promotions: true,
                milestones: false
            },
            recentActivity: [
                { id: 1, platform: 'Instagram', action: 'Posted new product: iPhone 15 Pro', time: '2 hours ago', engagement: '24 likes' },
                { id: 2, platform: 'Facebook', action: 'Shared customer review', time: '5 hours ago', engagement: '12 reactions' },
                { id: 3, platform: 'TikTok', action: 'Posted store tour video', time: '1 day ago', engagement: '156 views' },
                { id: 4, platform: 'Instagram', action: 'Story: Daily specials', time: '1 day ago', engagement: '45 views' }
            ]
        },
        
        reviews: {
            autoRequest: '3days',
            settings: {
                emailRequests: true,
                smsRequests: false,
                qrOnReceipt: true,
                autoRespond: false
            },
            distribution: [
                { stars: 5, percentage: 68, count: 193 },
                { stars: 4, percentage: 22, count: 62 },
                { stars: 3, percentage: 7, count: 20 },
                { stars: 2, percentage: 2, count: 6 },
                { stars: 1, percentage: 1, count: 3 }
            ],
            recent: [
                { 
                    id: 1, 
                    customer: 'Jennifer Smith', 
                    rating: 5, 
                    comment: 'Excellent service and great product quality! Will definitely come back.', 
                    date: '2 hours ago',
                    response: 'Thank you so much for your kind words! We appreciate your business.'
                },
                { 
                    id: 2, 
                    customer: 'Mark Johnson', 
                    rating: 4, 
                    comment: 'Good experience overall, staff was friendly and helpful.', 
                    date: '5 hours ago',
                    response: ''
                },
                { 
                    id: 3, 
                    customer: 'Lisa Brown', 
                    rating: 5, 
                    comment: 'Love this store! Always has what I need and prices are fair.', 
                    date: '1 day ago',
                    response: 'We\'re so glad you love shopping with us, Lisa!'
                }
            ]
        },
        
        onlineStore: {
            platforms: [
                { name: 'Shopify', connected: true, products: 245, lastSync: '30 min ago' },
                { name: 'WooCommerce', connected: false, products: 0, lastSync: '' },
                { name: 'Amazon', connected: true, products: 89, lastSync: '2 hours ago' },
                { name: 'eBay', connected: false, products: 0, lastSync: '' },
                { name: 'Etsy', connected: true, products: 156, lastSync: '1 hour ago' }
            ],
            syncSettings: {
                autoSync: true,
                syncInventory: true,
                syncPrices: true,
                syncOrders: true
            },
            recentSync: [
                { id: 1, action: 'Shopify inventory sync', time: '30 min ago', status: 'success', details: '245 products' },
                { id: 2, action: 'Amazon price update', time: '2 hours ago', status: 'success', details: '89 products' },
                { id: 3, action: 'Etsy new product sync', time: '3 hours ago', status: 'warning', details: '2 errors' },
                { id: 4, action: 'Shopify order import', time: '4 hours ago', status: 'success', details: '12 orders' }
            ]
        },
        
        generateQR() {
            this.qrGenerator.generated = true;
            
            switch(this.qrGenerator.type) {
                case 'product':
                    const product = this.products.find(p => p.id == this.qrGenerator.productId);
                    this.qrGenerator.description = `Product QR Code for ${product ? product.name : 'Selected Product'}`;
                    break;
                case 'wifi':
                    this.qrGenerator.description = `WiFi Access QR Code for ${this.qrGenerator.wifiSSID}`;
                    break;
                case 'payment':
                    this.qrGenerator.description = `${this.qrGenerator.paymentMethod} Payment Link ${this.qrGenerator.amount ? '($' + this.qrGenerator.amount + ')' : ''}`;
                    break;
                case 'menu':
                    this.qrGenerator.description = 'Digital Menu QR Code';
                    break;
                case 'review':
                    this.qrGenerator.description = 'Review Request QR Code';
                    break;
                case 'contact':
                    this.qrGenerator.description = 'Contact Information QR Code';
                    break;
            }
        },
        
        generateQRCodes() {
            alert('Bulk QR code generation started! (Simulation)');
        },
        
        downloadQR() {
            alert('QR Code downloaded! (Simulation)');
        },
        
        printQR() {
            alert('QR Code sent to printer! (Simulation)');
        },
        
        toggleConnection(platform) {
            platform.connected = !platform.connected;
            if (!platform.connected) {
                platform.username = '';
            }
        },
        
        generateReviewQR() {
            alert('Review QR Code generated! (Simulation)');
        },
        
        exportReviews() {
            alert('Reviews exported to CSV! (Simulation)');
        },
        
        respondToReview(id) {
            const response = prompt('Enter your response:');
            if (response) {
                const review = this.reviews.recent.find(r => r.id === id);
                if (review) {
                    review.response = response;
                }
            }
        },
        
        hideReview(id) {
            if (confirm('Hide this review?')) {
                this.reviews.recent = this.reviews.recent.filter(r => r.id !== id);
            }
        },
        
        togglePlatformConnection(platform) {
            platform.connected = !platform.connected;
            if (!platform.connected) {
                platform.products = 0;
                platform.lastSync = '';
            }
        },
        
        syncPlatform(platform) {
            alert(`Syncing ${platform.name}... (Simulation)`);
            platform.lastSync = 'Just now';
        },
        
        syncOnlineStore() {
            alert('Online store sync initiated! (Simulation)');
        },
        
        manualSync() {
            alert('Manual sync started for all platforms! (Simulation)');
        },
        
        viewSyncLogs() {
            alert('Opening sync logs... (Simulation)');
        }
    }
}
</script>
@endsection