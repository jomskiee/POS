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
                                <p class="text-3xl font-bold"> {{ $ordersToday   }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-document-text class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    <!-- My Sales -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">My Sales Today</p>
                                <p class="text-3xl font-bold">₱ {{ $salesToday }}</p>
                                <p class="text-blue-100 text-sm">
                                    @if($paidAmountGrowthPercent > 0)
                                    +{{ $paidAmountGrowthPercent }} from yesterday
                                    @endif
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-chart-pie class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    <!-- Commission -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Payment to Collect</p>
                                <p class="text-3xl font-bold">₱ {{ $salesBalance }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-currency-dollar class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium">Total Fish Boxes</p>
                                <p class="text-3xl font-bold"> {{ $totalFishBoxes }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-400 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-cube class="w-6 h-6" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Lists Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- My Recent Orders -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">My Recent Sales</h3>
                            <a href="{{ route('broker.sales.sales') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                        </div>
                        <div class="space-y-4">
                            @foreach ($recentSales as $sale)
                            <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-green-600 font-semibold text-sm"> #{{ $sale->id }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900"> {{ $sale->buyer_name }} ({{ $sale->formatted_items }})</p>
                                    @if($sale->status === \App\Constants\SalesStatusConstant::PAID)
                                        <p class="text-xs text-gray-500">Fully Paid  •</p>
                                    @elseif($sale->status === \App\Constants\SalesStatusConstant::PARTIALLY_PAID)
                                        <p class="text-xs text-gray-500">Partially Paid  • Balance: {{ $sale->total_amount - $sale->paid_amount }}</p>
                                    @else
                                        <p class="text-xs text-gray-500">Pending Payment  • Balance: {{ $sale->total_amount }}</p>
                                    @endif
                                    <!-- <p class="text-xs text-gray-500">Just completed • Table 5</p> -->
                                </div>
                                <span class="text-sm font-semibold text-gray-900">₱ {{ $sale->paid_amount }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- My Sales Performance -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">My Sales Performance</h3>
                        <div class="h-64 flex items-end justify-between space-x-2">
                            @php
                                $maxSales = $dailySalesData->max('sales');
                                $thisWeekTotal = $dailySalesData->sum('sales');
                                $lastWeekTotal = 0; // You can implement this if you have historical data
                                $growthPercent = $lastWeekTotal > 0 ? (($thisWeekTotal - $lastWeekTotal) / $lastWeekTotal) * 100 : 0;
                            @endphp
                            @foreach($dailySalesData as $dayData)
                                <div class="flex flex-col items-center flex-1">
                                    <div class="w-full bg-green-200 rounded-t relative"
                                         style="height: {{ $maxSales > 0 ? ($dayData['sales'] / $maxSales) * 240 : 0 }}px">
                                        <div class="w-full bg-green-600 rounded-t absolute bottom-0"
                                             style="height: {{ $maxSales > 0 ? ($dayData['sales'] / $maxSales) * 240 : 0 }}px">
                                        </div>
                                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-medium text-gray-700">
                                            ₱{{ number_format($dayData['sales'], 0) }}
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 mt-2">{{ $dayData['day'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900">₱{{ number_format($thisWeekTotal, 0) }}</p>
                                <p class="text-sm text-gray-500">This Week</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold {{ $growthPercent >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $growthPercent >= 0 ? '+' : '' }}{{ number_format($growthPercent, 1) }}%
                                </p>
                                <p class="text-sm text-gray-500">Growth</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
