@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'Business Intelligence']
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
        <main class="flex-1 overflow-auto p-6" x-data="businessIntelligence()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Business Intelligence</h1>
                            <p class="text-gray-600 mt-2">Advanced analytics and insights for your business</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 3 months</option>
                                <option>Last year</option>
                            </select>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Export Report</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Revenue Forecasting -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Revenue Forecast</p>
                                    <p class="text-2xl font-bold text-gray-900">$18,450</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-green-600">+15.3%</p>
                                <p class="text-xs text-gray-500">vs last month</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Progress</span>
                                <span>78%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Real-time Sales -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Real-time Sales</p>
                                    <p class="text-2xl font-bold text-gray-900">$2,847</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-blue-600">Live</p>
                                <p class="text-xs text-gray-500">Today</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-gray-600">187 transactions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Goal Tracking -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Monthly Goal</p>
                                    <p class="text-2xl font-bold text-gray-900">89%</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-purple-600">$89,500</p>
                                <p class="text-xs text-gray-500">of $100k</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>11 days left</span>
                                <span>On track</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 89%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Alerts -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Low Stock Alert</p>
                                    <p class="text-2xl font-bold text-gray-900">12</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-yellow-600">Critical</p>
                                <p class="text-xs text-gray-500">Items</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                                View Details →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Revenue Chart -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
                            <select class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Daily</option>
                                <option>Weekly</option>
                                <option>Monthly</option>
                            </select>
                        </div>
                        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <p class="text-gray-500">Revenue Chart</p>
                                <p class="text-sm text-gray-400">Chart.js integration ready</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sales by Category -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Sales by Category</h3>
                            <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">Electronics</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900 mr-2">$1,234</span>
                                    <div class="w-20 h-2 bg-gray-200 rounded-full">
                                        <div class="w-16 h-2 bg-blue-500 rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">Food & Beverages</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900 mr-2">$987</span>
                                    <div class="w-20 h-2 bg-gray-200 rounded-full">
                                        <div class="w-12 h-2 bg-green-500 rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">Clothing</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900 mr-2">$456</span>
                                    <div class="w-20 h-2 bg-gray-200 rounded-full">
                                        <div class="w-8 h-2 bg-purple-500 rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-700">Books</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900 mr-2">$170</span>
                                    <div class="w-20 h-2 bg-gray-200 rounded-full">
                                        <div class="w-3 h-2 bg-yellow-500 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comparison Reports -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Monthly Comparison -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Comparison</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">This Month</span>
                                <span class="text-sm font-medium text-gray-900">$18,450</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Last Month</span>
                                <span class="text-sm font-medium text-gray-900">$16,020</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t">
                                <span class="text-sm font-medium text-gray-900">Growth</span>
                                <span class="text-sm font-medium text-green-600">+15.2%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Yearly Comparison -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Yearly Comparison</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">This Year</span>
                                <span class="text-sm font-medium text-gray-900">$195,680</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Last Year</span>
                                <span class="text-sm font-medium text-gray-900">$178,450</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t">
                                <span class="text-sm font-medium text-gray-900">Growth</span>
                                <span class="text-sm font-medium text-green-600">+9.7%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Metrics -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance Metrics</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Avg. Order Value</span>
                                <span class="text-sm font-medium text-gray-900">$15.23</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Customer Retention</span>
                                <span class="text-sm font-medium text-gray-900">68.5%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Conversion Rate</span>
                                <span class="text-sm font-medium text-gray-900">3.2%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function businessIntelligence() {
    return {
        // Data and methods for business intelligence functionality
        init() {
            // Initialize charts and real-time data updates
            console.log('Business Intelligence Dashboard Initialized');
        }
    }
}
</script>
@endsection