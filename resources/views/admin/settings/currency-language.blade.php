<!-- Currency & Language Tab Content -->
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Currency Position</label>
                <select x-model="settings.currency.position" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="before">Before Amount ($100.00)</option>
                    <option value="after">After Amount (100.00$)</option>
                    <option value="before_space">Before with Space ($ 100.00)</option>
                    <option value="after_space">After with Space (100.00 $)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Decimal Places</label>
                <select x-model="settings.currency.decimals" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="0">0 (100)</option>
                    <option value="1">1 (100.0)</option>
                    <option value="2">2 (100.00)</option>
                    <option value="3">3 (100.000)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Thousand Separator</label>
                <select x-model="settings.currency.thousandSeparator" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value=",">Comma (1,000.00)</option>
                    <option value=".">Period (1.000,00)</option>
                    <option value=" ">Space (1 000.00)</option>
                    <option value="">None (1000.00)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Decimal Separator</label>
                <select x-model="settings.currency.decimalSeparator" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value=".">Period (100.00)</option>
                    <option value=",">Comma (100,00)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Language Settings -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Language Settings</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">System Language</label>
                <select x-model="settings.language.primary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="en">English</option>
                    <option value="es">Spanish (Español)</option>
                    <option value="fr">French (Français)</option>
                    <option value="de">German (Deutsch)</option>
                    <option value="it">Italian (Italiano)</option>
                    <option value="pt">Portuguese (Português)</option>
                    <option value="nl">Dutch (Nederlands)</option>
                    <option value="zh">Chinese (中文)</option>
                    <option value="ja">Japanese (日本語)</option>
                    <option value="ko">Korean (한국어)</option>
                    <option value="ar">Arabic (العربية)</option>
                    <option value="tl">Filipino (Tagalog)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                <select x-model="settings.language.dateFormat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="MM/DD/YYYY">MM/DD/YYYY (12/25/2024)</option>
                    <option value="DD/MM/YYYY">DD/MM/YYYY (25/12/2024)</option>
                    <option value="YYYY-MM-DD">YYYY-MM-DD (2024-12-25)</option>
                    <option value="DD.MM.YYYY">DD.MM.YYYY (25.12.2024)</option>
                    <option value="DD-MM-YYYY">DD-MM-YYYY (25-12-2024)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
                <select x-model="settings.language.timeFormat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="12">12 Hour (2:30 PM)</option>
                    <option value="24">24 Hour (14:30)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                <select x-model="settings.language.timezone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="UTC">UTC (Coordinated Universal Time)</option>
                    <option value="America/New_York">EST - Eastern Time</option>
                    <option value="America/Chicago">CST - Central Time</option>
                    <option value="America/Denver">MST - Mountain Time</option>
                    <option value="America/Los_Angeles">PST - Pacific Time</option>
                    <option value="Europe/London">GMT - Greenwich Mean Time</option>
                    <option value="Europe/Paris">CET - Central European Time</option>
                    <option value="Asia/Tokyo">JST - Japan Standard Time</option>
                    <option value="Asia/Shanghai">CST - China Standard Time</option>
                    <option value="Asia/Manila">PHT - Philippine Time</option>
                    <option value="Australia/Sydney">AEDT - Australian Eastern Time</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Currency Preview -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Format Preview</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Currency Format</p>
                <p class="text-xl font-bold text-gray-900" x-text="formatCurrencyPreview()"></p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Date Format</p>
                <p class="text-xl font-bold text-gray-900" x-text="formatDatePreview()"></p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Time Format</p>
                <p class="text-xl font-bold text-gray-900" x-text="formatTimePreview()"></p>
            </div>
        </div>
    </div>
</div>