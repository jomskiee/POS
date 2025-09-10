@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'Sales Management']
    ];
@endphp

<div class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: true }">
    <!-- Broker Sidebar Component -->
    @include('layouts.partials.broker-sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out" :style="sidebarOpen ? 'margin-left: 16rem;' : 'margin-left: 4rem;'">
        <!-- Broker Navbar Component -->
        @include('layouts.partials.broker-navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Sales Management</h1>
                            <p class="text-gray-600 mt-2">Track your sales performance and analytics</p>
                        </div>
                        <div class="flex space-x-3">
                            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                New Sale
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                    <form method="GET" action="{{ route('broker.sales.list') }}" x-data="{ search: '{{ request('search') }}', status: '{{ request('status') }}' }">
                        <input type="hidden" name="tab" value="fishBoxes">
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <div class="col-span-12 md:col-span-5">
                                <div class="relative">
                                    <input type="text"
                                        name="search"
                                        x-model="search"
                                        placeholder="Search ..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <select name="status" x-model="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Status</option>
                                    <option value="Deleted" {{ request('status') == 'Deleted' ? 'selected' : '' }}>Deleted</option>
                                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Partially_Paid" {{ request('status') == 'Partially_Paid' ? 'selected' : '' }}>Partially Paid</option>
                                    <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>

                                </select>
                            </div>
                            <div class="col-span-12 md:col-span-3 flex justify-end space-x-2">
                                <a href="{{ route('broker.sales.list', ['tab' => 'fishBoxes']) }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    Clear
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Sales Performance Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-white-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Today</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">47</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$2,845</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$142</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">85%</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Add more sample rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
