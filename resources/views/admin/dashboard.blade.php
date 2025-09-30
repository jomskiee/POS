@php
    $breadcrumbs = [
        ['title' => 'Dashboard']
    ];
@endphp

@extends('layouts.admin')

@section('content')
<div class="w-full" x-data="adminDashboard()">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-gray-600 mt-2">Welcome back <span class="text-blue-600 font-semibold">{{ Auth::user()->name }}</span>! Here's what's happening with your business today.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Brokers -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Brokers</p>
                                <p class="text-3xl font-bold">{{ number_format($totalBrokers) }}</p>
                                <p class="text-blue-100 text-sm">Active brokers</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-users class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    <!-- Total Fishboxes Sold -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Total Fishboxes Sold</p>
                                <p class="text-3xl font-bold">{{ number_format($totalFishBoxesSold) }}</p>
                                <p class="text-green-100 text-sm">Sold items</p>
                            </div>
                            <div class="w-12 h-12 bg-green-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-archive-box class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                     <!-- Total Fishboxes Missing -->
                     <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm font-medium">Total Fishboxes Missing</p>
                                <p class="text-3xl font-bold">{{ number_format($totalFishBoxesMissing) }}</p>
                                <p class="text-red-100 text-sm">Missing items</p>
                            </div>
                            <div class="w-12 h-12 bg-red-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-exclamation-triangle class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                     <!-- Total Fishboxes Returned -->
                     <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm font-medium">Total Fishboxes Returned</p>
                                <p class="text-3xl font-bold">{{ number_format($totalFishBoxesReturned) }}</p>
                                <p class="text-yellow-100 text-sm">Returned items</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-arrow-uturn-left class="w-6 h-6" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Sections Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Top Fish Types Sold -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Top Fish Types Sold</h3>
                            <a href="{{ route('admin.inventory.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($topFishTypes as $fishType)
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <x-heroicon-o-archive-box class="w-4 h-4 text-green-600" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $fishType['fish_type']->name }}</p>
                                            <p class="text-xs text-gray-500">Most popular fish type</p>
                                        </div>
                                    </div>
                                    <span class="text-green-600 text-sm font-medium">{{ $fishType['sold_count'] }} sold</span>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <x-heroicon-o-archive-box class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                                    <p class="text-gray-500 text-sm">No fish types sold yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Top Brokers This Month -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Top Brokers This Month</h3>
                            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($topBrokers as $brokerData)
                                <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-users class="w-5 h-5 text-blue-600" />
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $brokerData['broker']->name ?? 'Unknown Broker' }}</p>
                                        <p class="text-xs text-gray-500">{{ $brokerData['sales_count'] }} sales this month</p>
                                    </div>
                                    <span class="text-sm"><span class="text-green-600 font-semibold">{{ $brokerData['fishbox_count'] }}</span> <span class="text-black">Fishboxes Sold</span></span>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <x-heroicon-o-users class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                                    <p class="text-gray-500 text-sm">No broker sales this month</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
@endsection
