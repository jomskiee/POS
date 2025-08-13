@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'System Settings']
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
        <main class="flex-1 overflow-auto p-6" x-data="systemSettings()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
                            <p class="text-gray-600 mt-2">Configure tax settings, receipts, backups, and system preferences</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button @click="openBackupModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                <span>Backup System</span>
                            </button>
                            <button @click="saveAllSettings()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                <span>Save Settings</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'tax'" 
                                    :class="activeTab === 'tax' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Tax Configuration</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'currency'" 
                                    :class="activeTab === 'currency' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Currency & Language</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'receipts'" 
                                    :class="activeTab === 'receipts' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>Receipt Customization</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'backup'" 
                                    :class="activeTab === 'backup' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span>Backup & Restore</span>
                                </div>
                            </button>
                            <button @click="activeTab = 'preferences'" 
                                    :class="activeTab === 'preferences' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                    </svg>
                                    <span>System Preferences</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="space-y-6">
                    <!-- Tax Configuration Tab -->
                    <div x-show="activeTab === 'tax'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
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
                    </div>

                    <!-- Currency & Language Tab -->
                    <div x-show="activeTab === 'currency'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Currency Settings -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Currency Settings</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Currency</label>
                                        <select x-model="settings.currency.primary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="USD">USD - US Dollar ($)</option>
                                            <option value="EUR">EUR - Euro (€)</option>
                                            <option value="GBP">GBP - British Pound (£)</option>
                                            <option value="CAD">CAD - Canadian Dollar (C$)</option>
                                            <option value="AUD">AUD - Australian Dollar (A$)</option>
                                            <option value="JPY">JPY - Japanese Yen (¥)</option>
                                            <option value="PHP">PHP - Philippine Peso (₱)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Currency Symbol Position</label>
                                        <select x-model="settings.currency.symbolPosition" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="before">Before Amount ($100.00)</option>
                                            <option value="after">After Amount (100.00$)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Decimal Places</label>
                                        <select x-model="settings.currency.decimals" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="0">0 (100)</option>
                                            <option value="2">2 (100.00)</option>
                                            <option value="3">3 (100.000)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thousands Separator</label>
                                        <select x-model="settings.currency.separator" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value=",">, (1,000.00)</option>
                                            <option value=".">. (1.000,00)</option>
                                            <option value=" ">Space (1 000.00)</option>
                                            <option value="none">None (1000.00)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Language & Regional Settings -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Language & Regional</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">System Language</label>
                                        <select x-model="settings.language.primary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="en">English</option>
                                            <option value="es">Spanish</option>
                                            <option value="fr">French</option>
                                            <option value="de">German</option>
                                            <option value="it">Italian</option>
                                            <option value="pt">Portuguese</option>
                                            <option value="ja">Japanese</option>
                                            <option value="ko">Korean</option>
                                            <option value="zh">Chinese</option>
                                            <option value="hi">Hindi</option>
                                            <option value="ar">Arabic</option>
                                            <option value="ru">Russian</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Time Zone</label>
                                        <select x-model="settings.language.timezone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="UTC">UTC - Coordinated Universal Time</option>
                                            <option value="EST">EST - Eastern Standard Time</option>
                                            <option value="PST">PST - Pacific Standard Time</option>
                                            <option value="CST">CST - Central Standard Time</option>
                                            <option value="MST">MST - Mountain Standard Time</option>
                                            <option value="JST">JST - Japan Standard Time</option>
                                            <option value="PHT">PHT - Philippine Standard Time</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                                        <select x-model="settings.language.dateFormat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="MM/DD/YYYY">MM/DD/YYYY (12/25/2024)</option>
                                            <option value="DD/MM/YYYY">DD/MM/YYYY (25/12/2024)</option>
                                            <option value="YYYY-MM-DD">YYYY-MM-DD (2024-12-25)</option>
                                            <option value="DD-MM-YYYY">DD-MM-YYYY (25-12-2024)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
                                        <select x-model="settings.language.timeFormat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="12">12-hour (2:30 PM)</option>
                                            <option value="24">24-hour (14:30)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Customization Tab -->
                    <div x-show="activeTab === 'receipts'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Receipt Template -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Receipt Template</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Store Name</label>
                                        <input type="text" 
                                               x-model="settings.receipt.storeName"
                                               placeholder="Your Store Name"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Store Address</label>
                                        <textarea x-model="settings.receipt.storeAddress"
                                                  rows="3"
                                                  placeholder="123 Main Street&#10;City, State 12345&#10;Phone: (555) 123-4567"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Message</label>
                                        <textarea x-model="settings.receipt.footerMessage"
                                                  rows="2"
                                                  placeholder="Thank you for your business!&#10;Visit us again soon."
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Receipt Width</label>
                                        <select x-model="settings.receipt.width" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="80mm">80mm (Standard)</option>
                                            <option value="58mm">58mm (Compact)</option>
                                            <option value="104mm">104mm (Wide)</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.receipt.showLogo"
                                                   id="show-logo"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="show-logo" class="ml-2 text-sm text-gray-700">Show Store Logo</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.receipt.showBarcode"
                                                   id="show-barcode"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="show-barcode" class="ml-2 text-sm text-gray-700">Show Receipt Barcode</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.receipt.showQR"
                                                   id="show-qr"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="show-qr" class="ml-2 text-sm text-gray-700">Show QR Code for Digital Receipt</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Receipt Preview -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Receipt Preview</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="bg-white p-4 max-w-xs mx-auto text-center font-mono text-xs border border-gray-300 rounded">
                                        <div class="mb-2">
                                            <div x-show="settings.receipt.showLogo" class="w-12 h-12 bg-gray-200 mx-auto mb-2 rounded flex items-center justify-center">
                                                <span class="text-xs text-gray-500">LOGO</span>
                                            </div>
                                            <div class="font-bold text-sm" x-text="settings.receipt.storeName || 'Your Store Name'"></div>
                                            <div class="text-xs whitespace-pre-line" x-text="settings.receipt.storeAddress || '123 Main Street\nCity, State 12345\nPhone: (555) 123-4567'"></div>
                                        </div>
                                        <div class="border-t border-dashed border-gray-400 my-2"></div>
                                        <div class="text-left">
                                            <div class="flex justify-between">
                                                <span>Receipt #:</span>
                                                <span>R-2024-001</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Date:</span>
                                                <span>12/26/2024 2:30 PM</span>
                                            </div>
                                            <div class="border-t border-dashed border-gray-400 my-2"></div>
                                            <div class="space-y-1">
                                                <div class="flex justify-between">
                                                    <span>Coffee Bean (x2)</span>
                                                    <span>$12.00</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>Pastry (x1)</span>
                                                    <span>$4.50</span>
                                                </div>
                                            </div>
                                            <div class="border-t border-dashed border-gray-400 my-2"></div>
                                            <div class="flex justify-between">
                                                <span>Subtotal:</span>
                                                <span>$16.50</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Tax:</span>
                                                <span>$1.32</span>
                                            </div>
                                            <div class="flex justify-between font-bold">
                                                <span>Total:</span>
                                                <span>$17.82</span>
                                            </div>
                                        </div>
                                        <div class="border-t border-dashed border-gray-400 my-2"></div>
                                        <div class="text-xs whitespace-pre-line" x-text="settings.receipt.footerMessage || 'Thank you for your business!\nVisit us again soon.'"></div>
                                        <div x-show="settings.receipt.showBarcode" class="mt-2">
                                            <div class="w-20 h-6 bg-gray-800 mx-auto flex items-center justify-center">
                                                <span class="text-white text-xs">|||||||</span>
                                            </div>
                                        </div>
                                        <div x-show="settings.receipt.showQR" class="mt-2">
                                            <div class="w-12 h-12 bg-gray-800 mx-auto flex items-center justify-center">
                                                <span class="text-white text-xs">QR</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backup & Restore Tab -->
                    <div x-show="activeTab === 'backup'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Backup Settings -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Backup Configuration</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Auto Backup Schedule</label>
                                        <select x-model="settings.backup.schedule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="disabled">Disabled</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Backup Time</label>
                                        <input type="time" 
                                               x-model="settings.backup.time"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Retention Period</label>
                                        <select x-model="settings.backup.retention" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="7">7 days</option>
                                            <option value="30">30 days</option>
                                            <option value="90">90 days</option>
                                            <option value="365">1 year</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.backup.includeImages"
                                                   id="include-images"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="include-images" class="ml-2 text-sm text-gray-700">Include Product Images</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.backup.compressBackup"
                                                   id="compress-backup"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="compress-backup" class="ml-2 text-sm text-gray-700">Compress Backup Files</label>
                                        </div>
                                    </div>
                                    <div class="pt-4 space-y-3">
                                        <button @click="createBackup()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            Create Backup Now
                                        </button>
                                        <button @click="openRestoreModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            Restore from Backup
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Backup History -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Backups</h3>
                                <div class="space-y-3">
                                    <template x-for="backup in settings.backup.history" :key="backup.id">
                                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900" x-text="backup.name"></div>
                                                <div class="text-xs text-gray-500" x-text="backup.date + ' • ' + backup.size"></div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button @click="downloadBackup(backup.id)" class="text-blue-600 hover:text-blue-800 text-sm">
                                                    Download
                                                </button>
                                                <button @click="deleteBackup(backup.id)" class="text-red-600 hover:text-red-800 text-sm">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Preferences Tab -->
                    <div x-show="activeTab === 'preferences'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- General Preferences -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">General Preferences</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Default Landing Page</label>
                                        <select x-model="settings.preferences.landingPage" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="dashboard">Dashboard</option>
                                            <option value="pos">POS Terminal</option>
                                            <option value="sales">Sales & Analytics</option>
                                            <option value="inventory">Inventory & Stock</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Items Per Page</label>
                                        <select x-model="settings.preferences.itemsPerPage" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="10">10 items</option>
                                            <option value="25">25 items</option>
                                            <option value="50">50 items</option>
                                            <option value="100">100 items</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Low Stock Alert Threshold</label>
                                        <input type="number" 
                                               x-model="settings.preferences.lowStockThreshold"
                                               min="1"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.preferences.enableNotifications"
                                                   id="enable-notifications"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="enable-notifications" class="ml-2 text-sm text-gray-700">Enable Push Notifications</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.preferences.autoSave"
                                                   id="auto-save"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="auto-save" class="ml-2 text-sm text-gray-700">Auto-save Data</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.preferences.enableSounds"
                                                   id="enable-sounds"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="enable-sounds" class="ml-2 text-sm text-gray-700">Enable Sound Effects</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security & Session -->
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Security & Session</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                                        <select x-model="settings.preferences.sessionTimeout" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="15">15 minutes</option>
                                            <option value="30">30 minutes</option>
                                            <option value="60">1 hour</option>
                                            <option value="120">2 hours</option>
                                            <option value="480">8 hours</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Policy</label>
                                        <select x-model="settings.preferences.passwordPolicy" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="basic">Basic (8+ characters)</option>
                                            <option value="medium">Medium (8+ chars + numbers)</option>
                                            <option value="strong">Strong (8+ chars + numbers + symbols)</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.preferences.requireTwoFactor"
                                                   id="require-2fa"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="require-2fa" class="ml-2 text-sm text-gray-700">Require Two-Factor Authentication</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.preferences.logUserActivity"
                                                   id="log-activity"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="log-activity" class="ml-2 text-sm text-gray-700">Log User Activity</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="settings.preferences.requirePasswordChange"
                                                   id="require-password-change"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="require-password-change" class="ml-2 text-sm text-gray-700">Require Password Change Every 90 Days</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Modal -->
            <div x-show="showBackupModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeBackupModal()">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Create System Backup</h3>
                        <button @click="closeBackupModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-4">This will create a complete backup of your system including:</p>
                        <ul class="text-sm text-gray-600 space-y-1 mb-4">
                            <li>• Database (products, sales, users)</li>
                            <li>• System settings and configurations</li>
                            <li>• Product images (if enabled)</li>
                            <li>• Receipt templates</li>
                        </ul>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <p class="text-sm text-blue-700">
                                <strong>Note:</strong> This is a simulation. In a real system, this would create an actual backup file.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3">
                        <button @click="closeBackupModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button @click="confirmBackup()"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                            Create Backup
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function systemSettings() {
    return {
        activeTab: 'tax',
        showBackupModal: false,
        
        settings: {
            tax: {
                defaultRate: 8.25,
                display: 'inclusive',
                calculation: 'line',
                enableMultiple: false,
                rates: [
                    { name: 'Standard Tax', rate: 8.25 },
                    { name: 'Food Tax', rate: 4.00 },
                    { name: 'Luxury Tax', rate: 15.00 }
                ]
            },
            currency: {
                primary: 'USD',
                symbolPosition: 'before',
                decimals: 2,
                separator: ','
            },
            language: {
                primary: 'en',
                timezone: 'UTC',
                dateFormat: 'MM/DD/YYYY',
                timeFormat: '12'
            },
            receipt: {
                storeName: 'Your POS Store',
                storeAddress: '123 Main Street\nCity, State 12345\nPhone: (555) 123-4567',
                footerMessage: 'Thank you for your business!\nVisit us again soon.',
                width: '80mm',
                showLogo: true,
                showBarcode: true,
                showQR: false
            },
            backup: {
                schedule: 'daily',
                time: '02:00',
                retention: 30,
                includeImages: true,
                compressBackup: true,
                history: [
                    { id: 1, name: 'Auto Backup - Daily', date: 'Dec 26, 2024 2:00 AM', size: '25.4 MB' },
                    { id: 2, name: 'Manual Backup', date: 'Dec 25, 2024 5:30 PM', size: '24.8 MB' },
                    { id: 3, name: 'Auto Backup - Daily', date: 'Dec 25, 2024 2:00 AM', size: '24.6 MB' },
                    { id: 4, name: 'Auto Backup - Daily', date: 'Dec 24, 2024 2:00 AM', size: '24.2 MB' }
                ]
            },
            preferences: {
                landingPage: 'dashboard',
                itemsPerPage: 25,
                lowStockThreshold: 10,
                enableNotifications: true,
                autoSave: true,
                enableSounds: false,
                sessionTimeout: 60,
                passwordPolicy: 'medium',
                requireTwoFactor: false,
                logUserActivity: true,
                requirePasswordChange: false
            }
        },
        
        addTaxRate() {
            this.settings.tax.rates.push({ name: '', rate: 0 });
        },
        
        removeTaxRate(index) {
            this.settings.tax.rates.splice(index, 1);
        },
        
        openBackupModal() {
            this.showBackupModal = true;
        },
        
        closeBackupModal() {
            this.showBackupModal = false;
        },
        
        confirmBackup() {
            alert('Backup created successfully! (Simulation)');
            this.closeBackupModal();
            // Add new backup to history
            this.settings.backup.history.unshift({
                id: Date.now(),
                name: 'Manual Backup',
                date: new Date().toLocaleString(),
                size: '25.8 MB'
            });
        },
        
        createBackup() {
            this.openBackupModal();
        },
        
        openRestoreModal() {
            alert('Restore functionality - Select backup file to restore (Simulation)');
        },
        
        downloadBackup(id) {
            alert('Downloading backup with ID: ' + id + ' (Simulation)');
        },
        
        deleteBackup(id) {
            if (confirm('Are you sure you want to delete this backup?')) {
                this.settings.backup.history = this.settings.backup.history.filter(backup => backup.id !== id);
            }
        },
        
        saveAllSettings() {
            alert('All settings saved successfully! (Simulation)');
        }
    }
}
</script>
@endsection