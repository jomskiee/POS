@extends('layouts.broker')

@section('content')
<div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Broker Dashboard</h1>
                    <p class="text-gray-600 mt-2">Welcome back! Here's your sales performance and daily activities.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- My Orders Today -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">My Orders Today</p>
                                <p class="text-3xl font-bold">12</p>
                                <p class="text-green-100 text-sm">+3 from yesterday</p>
                            </div>
                            <div class="w-12 h-12 bg-green-400 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- My Sales -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">My Sales Today</p>
                                <p class="text-3xl font-bold">$1,234</p>
                                <p class="text-blue-100 text-sm">+12.5% from yesterday</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Commission -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">My Commission</p>
                                <p class="text-3xl font-bold">$156</p>
                                <p class="text-purple-100 text-sm">This month</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-400 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium">Pending Tasks</p>
                                <p class="text-3xl font-bold">5</p>
                                <p class="text-orange-100 text-sm">Due today</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-400 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Lists Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- My Recent Orders -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">My Recent Orders</h3>
                            <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-green-600 font-semibold text-sm">#101</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Coffee & Pastry</p>
                                    <p class="text-xs text-gray-500">Just completed • Table 5</p>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">$24.50</span>
                            </div>
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-sm">#102</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Lunch Combo</p>
                                    <p class="text-xs text-gray-500">15 min ago • Take away</p>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">$18.75</span>
                            </div>
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-purple-600 font-semibold text-sm">#103</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Beverages</p>
                                    <p class="text-xs text-gray-500">30 min ago • Table 2</p>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">$12.25</span>
                            </div>
                        </div>
                    </div>

                    <!-- My Sales Performance -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">My Sales Performance</h3>
                        <div class="h-64 bg-gradient-to-br from-green-50 to-teal-100 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <p class="text-gray-600 font-medium">Performance Chart</p>
                                <p class="text-gray-500 text-sm">Weekly sales comparison</p>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900">$1,456</p>
                                <p class="text-sm text-gray-500">This Week</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600">+8.3%</p>
                                <p class="text-sm text-gray-500">Growth</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Sections Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Today's Tasks -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Today's Tasks</h3>
                            <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">5 Pending</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Stock Check - Coffee Beans</p>
                                        <p class="text-xs text-gray-500">Completed at 9:00 AM</p>
                                    </div>
                                </div>
                                <span class="text-green-600 text-xs font-medium">Done</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Clean Equipment</p>
                                        <p class="text-xs text-gray-500">Due at 2:00 PM</p>
                                    </div>
                                </div>
                                <span class="text-orange-600 text-xs font-medium">Pending</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Submit Daily Report</p>
                                        <p class="text-xs text-gray-500">Due at 6:00 PM</p>
                                    </div>
                                </div>
                                <span class="text-blue-600 text-xs font-medium">Pending</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Alerts -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Stock Alerts</h3>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">3 Items Low</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.99-.833-2.464 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Espresso Beans</p>
                                    <p class="text-xs text-gray-500">Only 2 kg left</p>
                                </div>
                                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Notify</button>
                            </div>
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.99-.833-2.464 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Milk</p>
                                    <p class="text-xs text-gray-500">5 liters remaining</p>
                                </div>
                                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Notify</button>
                            </div>
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.99-.833-2.464 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Sugar Packets</p>
                                    <p class="text-xs text-gray-500">15 packets left</p>
                                </div>
                                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Notify</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
