@extends('layouts.admin')

@php
    $breadcrumbs = [
        ['title' => 'Sales & Transactions']
    ];
@endphp

@section('content')
<div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Sales & Analytics</h1>
                            <p class="text-gray-600 mt-2">Transaction management, payment processing, returns handling, and comprehensive sales analytics</p>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-lg mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-8 px-4 md:px-6" aria-label="Tabs">
                            <a href="{{ route('admin.sales.index', ['tab' => 'analysis']) }}"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $currentTab === 'analysis' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-chart-bar class="w-5 h-5" />
                                    <span>Sales Per Broker List</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.sales.index', ['tab' => 'fishbox-tracking']) }}"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $currentTab === 'fishbox-tracking' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-archive-box class="w-5 h-5" />
                                    <span>Fishbox Tracking</span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Sales Per Broker List Tab -->
                @if($currentTab === 'analysis')
                    @include('admin.sales.analysis')
                @endif

                <!-- Fishbox Tracking Tab -->
                @if($currentTab === 'fishbox-tracking')
                    @include('admin.sales.fishbox-tracking')
                @endif

            </div>
@endsection
