<!-- Budget Planning Tab Content -->
<div class="space-y-6">
    <!-- Budget Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Budget</p>
                    <p class="text-2xl font-bold text-gray-900">$50,000</p>
                    <p class="text-xs text-blue-600">For this quarter</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Spent</p>
                    <p class="text-2xl font-bold text-gray-900">$32,450</p>
                    <p class="text-xs text-orange-600">64.9% of budget</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Remaining</p>
                    <p class="text-2xl font-bold text-gray-900">$17,550</p>
                    <p class="text-xs text-green-600">35.1% remaining</p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget Categories -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Budget by Category</h3>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Add Category
            </button>
        </div>
        <div class="space-y-6">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Marketing & Advertising</span>
                    <span class="text-sm text-gray-500">$8,450 / $12,000</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-500 h-3 rounded-full" style="width: 70.4%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>70.4% used</span>
                    <span>$3,550 remaining</span>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Operating Expenses</span>
                    <span class="text-sm text-gray-500">$15,200 / $20,000</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-500 h-3 rounded-full" style="width: 76%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>76% used</span>
                    <span>$4,800 remaining</span>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Administrative</span>
                    <span class="text-sm text-gray-500">$5,800 / $8,000</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-purple-500 h-3 rounded-full" style="width: 72.5%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>72.5% used</span>
                    <span>$2,200 remaining</span>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Technology & Software</span>
                    <span class="text-sm text-gray-500">$3,000 / $10,000</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-yellow-500 h-3 rounded-full" style="width: 30%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>30% used</span>
                    <span>$7,000 remaining</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget vs Actual -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Budget vs Actual</h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                <div class="flex flex-col items-center space-y-2">
                    <div class="space-y-1">
                        <div class="w-12 bg-blue-500 rounded-t" style="height: 120px;" title="Budget: $12,000"></div>
                        <div class="w-12 bg-blue-300 rounded-t" style="height: 84px;" title="Actual: $8,450"></div>
                    </div>
                    <span class="text-xs text-gray-500">Marketing</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="space-y-1">
                        <div class="w-12 bg-green-500 rounded-t" style="height: 160px;" title="Budget: $20,000"></div>
                        <div class="w-12 bg-green-300 rounded-t" style="height: 122px;" title="Actual: $15,200"></div>
                    </div>
                    <span class="text-xs text-gray-500">Operating</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="space-y-1">
                        <div class="w-12 bg-purple-500 rounded-t" style="height: 64px;" title="Budget: $8,000"></div>
                        <div class="w-12 bg-purple-300 rounded-t" style="height: 46px;" title="Actual: $5,800"></div>
                    </div>
                    <span class="text-xs text-gray-500">Admin</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="space-y-1">
                        <div class="w-12 bg-yellow-500 rounded-t" style="height: 80px;" title="Budget: $10,000"></div>
                        <div class="w-12 bg-yellow-300 rounded-t" style="height: 24px;" title="Actual: $3,000"></div>
                    </div>
                    <span class="text-xs text-gray-500">Tech</span>
                </div>
            </div>
            <div class="flex items-center justify-center mt-4 space-x-6 text-xs">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gray-600 rounded"></div>
                    <span>Budget</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gray-400 rounded"></div>
                    <span>Actual</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Budget Alerts</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Marketing budget at 70%</p>
                        <p class="text-xs text-yellow-600">Consider reviewing upcoming campaigns</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-red-800">Operating expenses over 75%</p>
                        <p class="text-xs text-red-600">Monitor expenses carefully this month</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-green-800">Technology budget on track</p>
                        <p class="text-xs text-green-600">Good opportunity for planned investments</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>