@extends('layouts.admin')

@php
    $breadcrumbs = [
        ['title' => 'Sales & Transactions']
    ];
@endphp

@section('content')
<div class="w-full" x-data="salesManagement()" x-init="activeTab = '{{ $currentTab }}'">
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
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('admin.sales.index', ['tab' => 'analysis']) }}"
                               :class="activeTab === 'analysis' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                               class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-chart-bar class="w-5 h-5" />
                                    <span>Sales Analysis</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.sales.index', ['tab' => 'transactions']) }}"
                               :class="activeTab === 'transactions' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                               class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-document-text class="w-5 h-5" />
                                    <span>Sales History</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.sales.index', ['tab' => 'fishbox-tracking']) }}"
                               :class="activeTab === 'fishbox-tracking' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                               class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-archive-box class="w-5 h-5" />
                                    <span>Fishbox Tracking</span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Sales Analysis Tab -->
                @if($currentTab === 'analysis')
                    @include('admin.sales.analysis')
                @endif

                <!-- Transaction History Tab -->
                @if($currentTab === 'transactions')
                    @include('admin.sales.transactions')
                @endif

                <!-- Fishbox Tracking Tab -->
                @if($currentTab === 'fishbox-tracking')
                    @include('admin.sales.fishbox-tracking')
                @endif

            </div>

<script>
function salesManagement() {
    return {
        activeTab: '{{ $currentTab }}'
    }
}
</script>
@endsection
