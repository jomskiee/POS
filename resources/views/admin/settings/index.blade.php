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
                        @include('admin.settings.tax-configuration')
                    </div>

                    <!-- Currency & Language Tab -->
                    <div x-show="activeTab === 'currency'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        @include('admin.settings.currency-language')
                    </div>

                    <!-- Receipt Customization Tab -->
                    <div x-show="activeTab === 'receipts'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        @include('admin.settings.receipt-customization')
                    </div>

                    <!-- Backup & Restore Tab -->
                    <div x-show="activeTab === 'backup'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        @include('admin.settings.backup-restore')
                    </div>

                    <!-- System Preferences Tab -->
                    <div x-show="activeTab === 'preferences'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        @include('admin.settings.system-preferences')
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
                    { name: 'Standard VAT', rate: 8.25 },
                    { name: 'Food & Beverage', rate: 5.0 },
                    { name: 'Luxury Items', rate: 12.0 }
                ]
            },
            currency: {
                primary: 'USD',
                position: 'before',
                decimals: 2,
                thousandSeparator: ',',
                decimalSeparator: '.'
            },
            language: {
                primary: 'en',
                dateFormat: 'MM/DD/YYYY',
                timeFormat: '12',
                timezone: 'America/New_York'
            },
            receipt: {
                width: '80',
                paperType: 'thermal',
                fontSize: 'medium',
                template: 'standard',
                showLogo: true,
                showBarcode: false,
                showTaxBreakdown: true,
                showQrCode: false,
                companyName: 'Your Business Name',
                address1: '123 Main Street',
                address2: 'City, State 12345',
                phone: '(555) 123-4567',
                email: 'info@yourbusiness.com',
                website: 'www.yourbusiness.com',
                headerMessage: 'Welcome! Thank you for shopping with us.',
                footerMessage: 'Thank you for your business! Please come again.'
            },
            backup: {
                frequency: 'daily',
                time: '02:00',
                retention: '30',
                storage: 'local',
                includeDatabase: true,
                includeFiles: true,
                includeImages: true,
                compression: true,
                encryption: false
            },
            restore: {
                type: 'full',
                overwriteExisting: false,
                createBackupBeforeRestore: true,
                validateData: true
            },
            general: {
                businessName: 'Your Business Name',
                pageSize: '25',
                sessionTimeout: '60',
                lowStockThreshold: 10,
                autoSave: true,
                confirmDelete: true,
                showTutorials: true,
                enableSounds: false
            },
            security: {
                passwordPolicy: 'standard',
                loginAttempts: '5',
                lockoutDuration: '15',
                twoFactorAuth: false,
                forcePasswordChange: false,
                logFailedAttempts: true,
                enableAuditLog: true
            },
            pos: {
                defaultPayment: 'cash',
                autoPrint: 'ask',
                cashDrawer: 'auto',
                enableBarcode: true,
                enableDiscount: true,
                enableReturns: true,
                customerDisplay: false,
                loyaltyProgram: false,
                emailReceipts: true
            },
            notifications: {
                lowStock: true,
                dailySales: true,
                systemUpdates: false,
                backupStatus: true,
                transactionAlerts: true,
                userActivity: false,
                maintenanceAlerts: true,
                errorAlerts: true
            }
        },
        
        openBackupModal() {
            this.showBackupModal = true;
        },
        
        closeBackupModal() {
            this.showBackupModal = false;
        },
        
        saveAllSettings() {
            alert('Settings saved successfully!');
        },
        
        addTaxRate() {
            this.settings.tax.rates.push({ name: '', rate: 0 });
        },
        
        removeTaxRate(index) {
            this.settings.tax.rates.splice(index, 1);
        },
        
        formatCurrencyPreview() {
            const amount = 1234.56;
            const symbol = this.getCurrencySymbol();
            const formatted = this.formatNumber(amount);
            
            switch(this.settings.currency.position) {
                case 'before': return symbol + formatted;
                case 'after': return formatted + symbol;
                case 'before_space': return symbol + ' ' + formatted;
                case 'after_space': return formatted + ' ' + symbol;
                default: return symbol + formatted;
            }
        },
        
        formatDatePreview() {
            const date = new Date();
            const format = this.settings.language.dateFormat;
            
            switch(format) {
                case 'MM/DD/YYYY': return (date.getMonth() + 1).toString().padStart(2, '0') + '/' + date.getDate().toString().padStart(2, '0') + '/' + date.getFullYear();
                case 'DD/MM/YYYY': return date.getDate().toString().padStart(2, '0') + '/' + (date.getMonth() + 1).toString().padStart(2, '0') + '/' + date.getFullYear();
                case 'YYYY-MM-DD': return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
                case 'DD.MM.YYYY': return date.getDate().toString().padStart(2, '0') + '.' + (date.getMonth() + 1).toString().padStart(2, '0') + '.' + date.getFullYear();
                case 'DD-MM-YYYY': return date.getDate().toString().padStart(2, '0') + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getFullYear();
                default: return date.toLocaleDateString();
            }
        },
        
        formatTimePreview() {
            const date = new Date();
            return this.settings.language.timeFormat === '12' ? date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});
        },
        
        getCurrencySymbol() {
            const symbols = {
                'USD': '$', 'EUR': '€', 'GBP': '£', 'CAD': 'C$', 
                'AUD': 'A$', 'JPY': '¥', 'PHP': '₱'
            };
            return symbols[this.settings.currency.primary] || '$';
        },
        
        formatNumber(amount) {
            return amount.toLocaleString('en-US', {
                minimumFractionDigits: this.settings.currency.decimals,
                maximumFractionDigits: this.settings.currency.decimals
            });
        },
        
        createBackup() {
            alert('Backup created successfully!');
        },
        
        restoreSystem() {
            if (confirm('Are you sure you want to restore the system? This action cannot be undone.')) {
                alert('System restore initiated...');
            }
        },
        
        refreshBackupList() {
            alert('Backup list refreshed!');
        },
        
        printTestReceipt() {
            alert('Test receipt sent to printer!');
        }
    }
}
</script>
@endsection