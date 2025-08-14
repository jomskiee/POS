<!-- Backup & Restore Tab Content -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Backup Settings -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Backup Configuration</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Backup Frequency</label>
                <select x-model="settings.backup.frequency" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="manual">Manual Only</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Backup Time</label>
                <input type="time" x-model="settings.backup.time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Retention Period</label>
                <select x-model="settings.backup.retention" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="7">7 Days</option>
                    <option value="30">30 Days</option>
                    <option value="90">90 Days</option>
                    <option value="365">1 Year</option>
                    <option value="unlimited">Unlimited</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Storage Location</label>
                <select x-model="settings.backup.storage" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="local">Local Server</option>
                    <option value="cloud">Cloud Storage</option>
                    <option value="external">External Drive</option>
                </select>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <h4 class="text-md font-medium text-gray-900">Backup Options</h4>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.backup.includeDatabase" id="backup-db" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="backup-db" class="ml-2 text-sm text-gray-700">Include Database</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.backup.includeFiles" id="backup-files" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="backup-files" class="ml-2 text-sm text-gray-700">Include System Files</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.backup.includeImages" id="backup-images" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="backup-images" class="ml-2 text-sm text-gray-700">Include Product Images</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.backup.compression" id="backup-compress" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="backup-compress" class="ml-2 text-sm text-gray-700">Enable Compression</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.backup.encryption" id="backup-encrypt" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="backup-encrypt" class="ml-2 text-sm text-gray-700">Enable Encryption</label>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button @click="createBackup()" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                <span>Create Backup Now</span>
            </button>
        </div>
    </div>

    <!-- Restore Options -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Restore System</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Backup File</label>
                <input type="file" accept=".zip,.sql,.tar,.gz" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Restore Type</label>
                <select x-model="settings.restore.type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="full">Full System Restore</option>
                    <option value="database">Database Only</option>
                    <option value="files">Files Only</option>
                    <option value="selective">Selective Restore</option>
                </select>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <h4 class="text-md font-medium text-gray-900">Restore Options</h4>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.restore.overwriteExisting" id="restore-overwrite" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="restore-overwrite" class="ml-2 text-sm text-gray-700">Overwrite Existing Data</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.restore.createBackupBeforeRestore" id="restore-backup" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="restore-backup" class="ml-2 text-sm text-gray-700">Create Backup Before Restore</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" x-model="settings.restore.validateData" id="restore-validate" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="restore-validate" class="ml-2 text-sm text-gray-700">Validate Data Integrity</label>
                </div>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <button @click="restoreSystem()" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Restore System</span>
            </button>
            <p class="text-xs text-red-600 text-center">⚠️ This action cannot be undone. Ensure you have a current backup.</p>
        </div>
    </div>
</div>

<!-- Backup History -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Backup History</h3>
            <button @click="refreshBackupList()" class="text-blue-600 hover:text-blue-800 text-sm">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Dec 26, 2024 10:30 AM</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Full Backup</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">245.7 MB</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">Download</button>
                            <button class="text-orange-600 hover:text-orange-800">Restore</button>
                            <button class="text-red-600 hover:text-red-800">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Dec 25, 2024 10:30 AM</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Database</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">42.3 MB</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">Download</button>
                            <button class="text-orange-600 hover:text-orange-800">Restore</button>
                            <button class="text-red-600 hover:text-red-800">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Dec 24, 2024 10:30 AM</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Full Backup</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">238.1 MB</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">Download</button>
                            <button class="text-orange-600 hover:text-orange-800">Restore</button>
                            <button class="text-red-600 hover:text-red-800">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>