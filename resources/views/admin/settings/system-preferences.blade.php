<!-- System Preferences Tab Content -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- General Preferences -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">General Preferences</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Business Name</label>
                <input type="text" x-model="settings.general.businessName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Your Business Name">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Page Size</label>
                <select x-model="settings.general.pageSize" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="10">10 items per page</option>
                    <option value="25">25 items per page</option>
                    <option value="50">50 items per page</option>
                    <option value="100">100 items per page</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                <select x-model="settings.general.sessionTimeout" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="30">30 minutes</option>
                    <option value="60">1 hour</option>
                    <option value="120">2 hours</option>
                    <option value="480">8 hours</option>
                    <option value="0">Never expire</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Low Stock Threshold</label>
                <input type="number" x-model="settings.general.lowStockThreshold" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="10">
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <h4 class="text-md font-medium text-gray-900">System Behavior</h4>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.general.autoSave" id="auto-save" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="auto-save" class="ml-2 text-sm text-gray-700">Enable Auto-save</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.general.confirmDelete" id="confirm-delete" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="confirm-delete" class="ml-2 text-sm text-gray-700">Confirm before delete</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.general.showTutorials" id="show-tutorials" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="show-tutorials" class="ml-2 text-sm text-gray-700">Show tutorial tips</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.general.enableSounds" id="enable-sounds" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="enable-sounds" class="ml-2 text-sm text-gray-700">Enable notification sounds</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Settings -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Security Settings</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Policy</label>
                <select x-model="settings.security.passwordPolicy" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="basic">Basic (6+ characters)</option>
                    <option value="standard">Standard (8+ chars, numbers)</option>
                    <option value="strong">Strong (8+ chars, mixed case, symbols)</option>
                    <option value="very_strong">Very Strong (12+ chars, complex)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Login Attempts Limit</label>
                <select x-model="settings.security.loginAttempts" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="3">3 attempts</option>
                    <option value="5">5 attempts</option>
                    <option value="10">10 attempts</option>
                    <option value="unlimited">Unlimited</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Account Lockout Duration</label>
                <select x-model="settings.security.lockoutDuration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="5">5 minutes</option>
                    <option value="15">15 minutes</option>
                    <option value="30">30 minutes</option>
                    <option value="60">1 hour</option>
                    <option value="1440">24 hours</option>
                </select>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <h4 class="text-md font-medium text-gray-900">Security Features</h4>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.security.twoFactorAuth" id="2fa" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="2fa" class="ml-2 text-sm text-gray-700">Enable Two-Factor Authentication</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.security.forcePasswordChange" id="force-password" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="force-password" class="ml-2 text-sm text-gray-700">Force password change every 90 days</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.security.logFailedAttempts" id="log-failed" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="log-failed" class="ml-2 text-sm text-gray-700">Log failed login attempts</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.security.enableAuditLog" id="audit-log" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="audit-log" class="ml-2 text-sm text-gray-700">Enable audit logging</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- POS Terminal Settings -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">POS Terminal Settings</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Payment Method</label>
                <select x-model="settings.pos.defaultPayment" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="cash">Cash</option>
                    <option value="card">Credit/Debit Card</option>
                    <option value="digital">Digital Wallet</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Receipt Auto-Print</label>
                <select x-model="settings.pos.autoPrint" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="always">Always print</option>
                    <option value="ask">Ask customer</option>
                    <option value="never">Never print</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cash Drawer Behavior</label>
                <select x-model="settings.pos.cashDrawer" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="auto">Open automatically</option>
                    <option value="manual">Manual open only</option>
                    <option value="disabled">Disabled</option>
                </select>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-3">
                <h4 class="text-md font-medium text-gray-900">POS Features</h4>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.pos.enableBarcode" id="pos-barcode" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="pos-barcode" class="ml-2 text-sm text-gray-700">Enable barcode scanning</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.pos.enableDiscount" id="pos-discount" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="pos-discount" class="ml-2 text-sm text-gray-700">Allow discounts</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.pos.enableReturns" id="pos-returns" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="pos-returns" class="ml-2 text-sm text-gray-700">Enable returns/refunds</label>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-md font-medium text-gray-900">Customer Features</h4>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.pos.customerDisplay" id="customer-display" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="customer-display" class="ml-2 text-sm text-gray-700">Customer-facing display</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.pos.loyaltyProgram" id="loyalty-program" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="loyalty-program" class="ml-2 text-sm text-gray-700">Loyalty program integration</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.pos.emailReceipts" id="email-receipts" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="email-receipts" class="ml-2 text-sm text-gray-700">Email receipt option</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Settings -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Preferences</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h4 class="text-md font-medium text-gray-900 mb-3">Email Notifications</h4>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.lowStock" id="notify-stock" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-stock" class="ml-2 text-sm text-gray-700">Low stock alerts</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.dailySales" id="notify-sales" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-sales" class="ml-2 text-sm text-gray-700">Daily sales reports</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.systemUpdates" id="notify-updates" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-updates" class="ml-2 text-sm text-gray-700">System updates</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.backupStatus" id="notify-backup" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-backup" class="ml-2 text-sm text-gray-700">Backup completion status</label>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-md font-medium text-gray-900 mb-3">In-App Notifications</h4>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.transactionAlerts" id="notify-transactions" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-transactions" class="ml-2 text-sm text-gray-700">Transaction alerts</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.userActivity" id="notify-activity" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-activity" class="ml-2 text-sm text-gray-700">User activity notifications</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.maintenanceAlerts" id="notify-maintenance" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-maintenance" class="ml-2 text-sm text-gray-700">Maintenance alerts</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" x-model="settings.notifications.errorAlerts" id="notify-errors" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="notify-errors" class="ml-2 text-sm text-gray-700">Error notifications</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>