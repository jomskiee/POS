<!-- Admin Sales Analysis Tab Content -->
<div class="space-y-6">
    <!-- Admin Analysis Filters -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.sales.index', ['tab' => 'analysis']) }}" x-data="{
            status: '{{ request('status') }}',
            dateFrom: '{{ request('date_from', $dateFrom) }}',
            dateTo: '{{ request('date_to', $dateTo) }}'
        }">
            <input type="hidden" name="tab" value="analysis">
            <div class="analytics-filter-layout">
                <!-- Status Filter -->
                <div class="status-field">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" x-model="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        @foreach($statusOptions as $statusValue => $statusDisplayName)
                            <option value="{{ $statusValue }}" {{ request('status') == $statusValue ? 'selected' : '' }}>
                                {{ $statusDisplayName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div class="fish-type-field">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date"
                        name="date_from"
                        x-model="dateFrom"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Date To -->
                <div class="fish-type-field">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date"
                        name="date_to"
                        x-model="dateTo"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Action Buttons -->
                <div class="buttons-field flex justify-end space-x-2">
                    <a href="{{ route('admin.sales.index', ['tab' => 'analysis']) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Clear
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Apply
                    </button>
                </div>
        </div>
        </form>
    </div>

    <!-- Sales Performance Summary -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Sales Performance Summary</h3>
            <div class="text-sm text-gray-500">Period Analysis</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Period Statistics -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <x-heroicon-o-calendar-days class="w-5 h-5 text-blue-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Period Duration</p>
                        <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($dateFrom)->diffInDays(\Carbon\Carbon::parse($dateTo)) + 1 }} days</p>
                    </div>
                </div>
            </div>

            <!-- Revenue Growth -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <x-heroicon-o-arrow-trending-up class="w-5 h-5 text-green-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Daily Revenue Avg</p>
                        <p class="text-lg font-semibold text-gray-900">₱{{ number_format($totalRevenue / max(1, \Carbon\Carbon::parse($dateFrom)->diffInDays(\Carbon\Carbon::parse($dateTo)) + 1), 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Frequency -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-100 p-2 rounded-lg">
                        <x-heroicon-o-clock class="w-5 h-5 text-purple-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Orders per Day</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($totalOrders / max(1, \Carbon\Carbon::parse($dateFrom)->diffInDays(\Carbon\Carbon::parse($dateTo)) + 1), 1) }}</p>
                    </div>
                </div>
            </div>

            <!-- Market Share -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-orange-100 p-2 rounded-lg">
                        <x-heroicon-o-chart-pie class="w-5 h-5 text-orange-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Brokers</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $topBrokers->count() }} / {{ $totalBrokers }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Insights -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Average Order Value -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Average Order Value</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0, 2) }}</p>
                    <div class="flex items-center mt-1">
                        <span class="text-sm text-gray-500">Per transaction</span>
                    </div>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <x-heroicon-o-calculator class="w-6 h-6 text-blue-600" />
                </div>
            </div>
        </div>

        <!-- Revenue per Broker -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Revenue per Broker</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalBrokers > 0 ? $totalRevenue / $totalBrokers : 0, 2) }}</p>
                    <div class="flex items-center mt-1">
                        <span class="text-sm text-gray-500">Average performance</span>
                    </div>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <x-heroicon-o-chart-bar class="w-6 h-6 text-green-600" />
                </div>
            </div>
        </div>

        <!-- Conversion Rate -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sales Conversion</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalBrokers > 0 ? number_format(($totalOrders / $totalBrokers) * 100, 1) : 0 }}%</p>
                    <div class="flex items-center mt-1">
                        <span class="text-sm text-gray-500">Orders per broker</span>
                    </div>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <x-heroicon-o-arrow-trending-up class="w-6 h-6 text-purple-600" />
                </div>
            </div>
        </div>

        <!-- Top Performer -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Top Broker</p>
                    <p class="text-lg font-bold text-gray-900">{{ $topBrokers->isNotEmpty() ? $topBrokers->first()['broker']->name : 'N/A' }}</p>
                    <div class="flex items-center mt-1">
                        <span class="text-sm text-gray-500">{{ $topBrokers->isNotEmpty() ? $topBrokers->first()['sales_count'] . ' sales' : 'No data' }}</span>
                    </div>
                </div>
                <div class="bg-orange-50 p-3 rounded-full">
                    <x-heroicon-o-trophy class="w-6 h-6 text-orange-600" />
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Trend Analysis -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trend Analysis</h3>
                <div class="text-sm text-gray-500">Period Overview</div>
            </div>
            <div class="h-64 flex items-end justify-between space-x-2">
                @php
                    $maxValue = max(array_column($dailySalesData, 'value'));
                    $totalPeriodRevenue = array_sum(array_column($dailySalesData, 'value'));
                @endphp
                @foreach($dailySalesData as $index => $day)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-blue-200 rounded-t relative"
                             style="height: {{ $maxValue > 0 ? ($day['value'] / $maxValue) * 240 : 0 }}px">
                            <div class="w-full bg-blue-600 rounded-t absolute bottom-0"
                                 style="height: {{ $maxValue > 0 ? ($day['value'] / $maxValue) * 240 : 0 }}px">
                            </div>
                            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-medium text-gray-700">
                                ₱{{ number_format($day['value'], 0) }}
                        </div>
                    </div>
                        <span class="text-xs text-gray-500 mt-2">{{ $day['label'] }}</span>
            </div>
                @endforeach
        </div>
            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Peak Day:</span>
                        <span class="font-medium text-gray-900">
                            @php
                                $peakDay = collect($dailySalesData)->sortByDesc('value')->first();
                            @endphp
                            {{ $peakDay['label'] }} (₱{{ number_format($peakDay['value'], 0) }})
                        </span>
            </div>
                    <div>
                        <span class="text-gray-600">Daily Average:</span>
                        <span class="font-medium text-gray-900">₱{{ number_format($totalPeriodRevenue / count($dailySalesData), 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- Broker Performance Analysis -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Broker Performance Analysis</h3>
                <div class="text-sm text-gray-500">Top Performers</div>
            </div>
            <div class="space-y-4">
                @forelse($topBrokers as $index => $brokerData)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 {{ $index === 0 ? 'bg-yellow-100' : 'bg-green-100' }} rounded-lg flex items-center justify-center">
                                @if($index === 0)
                                    <x-heroicon-o-trophy class="w-4 h-4 text-yellow-600" />
                                @else
                                    <span class="text-green-600 font-semibold text-sm">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $brokerData['broker']->name ?? 'Unknown Broker' }}</p>
                                <p class="text-xs text-gray-500">{{ $brokerData['sales_count'] }} sales • {{ $topBrokers->isNotEmpty() && $topBrokers->first()['total_sales'] > 0 ? number_format(($brokerData['total_sales'] / $topBrokers->first()['total_sales']) * 100, 1) : 0 }}% of top performer</p>
                            </div>
                            </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">₱{{ number_format($brokerData['total_sales'], 2) }}</p>
                            <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $topBrokers->isNotEmpty() && $topBrokers->first()['total_sales'] > 0 ? ($brokerData['total_sales'] / $topBrokers->first()['total_sales']) * 100 : 0 }}%"></div>
                        </div>
                </div>
            </div>
                @empty
                    <div class="text-center py-8">
                        <x-heroicon-o-users class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                        <p class="text-gray-500 text-sm">No broker sales data available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Market Analysis Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Fish Type Market Analysis -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Fish Type Market Analysis</h3>
                <div class="text-sm text-gray-500">Demand Insights</div>
            </div>
            <div class="space-y-4">
                @forelse($topFishTypes as $index => $fishType)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 {{ $index === 0 ? 'bg-yellow-100' : 'bg-blue-100' }} rounded-lg flex items-center justify-center">
                                @if($index === 0)
                                    <x-heroicon-o-star class="w-4 h-4 text-yellow-600" />
                                @else
                                    <span class="text-blue-600 font-semibold text-sm">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $fishType['fish_type']->name }}</p>
                                <p class="text-xs text-gray-500">{{ $fishType['sold_count'] }} units • {{ $topFishTypes->isNotEmpty() && $topFishTypes->first()['sold_count'] > 0 ? number_format(($fishType['sold_count'] / $topFishTypes->first()['sold_count']) * 100, 1) : 0 }}% of top seller</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $fishType['sold_count'] }}</p>
                            <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $topFishTypes->isNotEmpty() && $topFishTypes->first()['sold_count'] > 0 ? ($fishType['sold_count'] / $topFishTypes->first()['sold_count']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <x-heroicon-o-archive-box class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                        <p class="text-gray-500 text-sm">No fish type sales data available</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Payment Method Analysis -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Payment Method Analysis</h3>
                <div class="text-sm text-gray-500">Transaction Patterns</div>
            </div>
            <div class="space-y-4">
                @forelse($paymentMethods as $method)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full {{ $method['color'] }}"></div>
                                <span class="text-sm font-medium text-gray-700">{{ $method['name'] }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $method['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div class="h-3 rounded-full {{ $method['color'] }}" style="width: {{ $method['percentage'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $method['transactions'] }} transactions</span>
                            <span>₱{{ number_format($method['amount'], 2) }}</span>
                        </div>
            </div>
                @empty
                    <div class="text-center py-8">
                        <x-heroicon-o-credit-card class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                        <p class="text-gray-500 text-sm">No payment data available</p>
                        </div>
                @endforelse
                    </div>
            </div>
        </div>

    <!-- Sales Status Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales Status Breakdown -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Sales Status Breakdown</h3>
                <div class="text-sm text-gray-500">Payment Status</div>
            </div>
            <div class="space-y-4">
                @foreach($salesStatusBreakdown['breakdown'] as $statusValue => $data)
                    <div class="p-4 {{ $data['bg_class'] }} rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full {{ $data['progress_color'] }}"></div>
                                <span class="text-sm font-medium text-gray-700">{{ $data['display_name'] }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ number_format($data['percentage'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div class="h-3 rounded-full {{ $data['progress_color'] }}" style="width: {{ $data['percentage'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $data['count'] }} orders</span>
                            <span>₱{{ number_format($data['total_amount'], 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payment Conversion Analysis -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Payment Conversion Analysis</h3>
                <div class="text-sm text-gray-500">Conversion Rates</div>
            </div>
            <div class="space-y-6">
                <!-- Full Payment Conversion -->
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($paymentConversionData['conversion_rate'], 1) }}%</div>
                    <div class="text-sm text-gray-600">Full Payment Rate</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $paymentConversionData['paid_orders'] }} of {{ $paymentConversionData['total_orders'] }} orders</div>
                </div>

                <!-- Partial Payment Conversion -->
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($paymentConversionData['partial_conversion_rate'], 1) }}%</div>
                    <div class="text-sm text-gray-600">Partial Payment Rate</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $paymentConversionData['partially_paid_orders'] }} of {{ $paymentConversionData['total_orders'] }} orders</div>
                </div>

                <!-- Outstanding Payments -->
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $paymentConversionData['active_orders'] }}</div>
                    <div class="text-sm text-gray-600">Outstanding Orders</div>
                    <div class="text-xs text-gray-500 mt-1">Awaiting payment</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Stock Status Overview -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Stock Status Overview</h3>
                <div class="text-sm text-gray-500">Current Inventory</div>
            </div>
            <div class="space-y-4">
                @foreach($inventoryAnalysisData['stock_status'] as $statusName => $data)
                    <div class="p-4 {{ $data['bg_class'] }} rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full {{ $data['color_class'] }}"></div>
                                <span class="text-sm font-medium text-gray-700">{{ $statusName }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ number_format($data['percentage'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div class="h-3 rounded-full {{ $data['color_class'] }}" style="width: {{ $data['percentage'] }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $data['count'] }} fish boxes
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Inventory Turnover Analysis -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Inventory Turnover Analysis</h3>
                <div class="text-sm text-gray-500">Sales Efficiency</div>
            </div>
            <div class="space-y-6">
                <!-- Turnover Rate -->
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($inventoryAnalysisData['turnover_rate'], 1) }}%</div>
                    <div class="text-sm text-gray-600">Inventory Turnover Rate</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $inventoryAnalysisData['sold_count'] }} sold of {{ $inventoryAnalysisData['total_inventory'] }} total</div>
                </div>

                <!-- Stock Availability -->
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $inventoryAnalysisData['in_stock_count'] }}</div>
                    <div class="text-sm text-gray-600">Available Stock</div>
                    <div class="text-xs text-gray-500 mt-1">Ready for sale</div>
                </div>

                <!-- Sales Performance -->
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ $inventoryAnalysisData['sold_count'] }}</div>
                    <div class="text-sm text-gray-600">Total Sold</div>
                    <div class="text-xs text-gray-500 mt-1">All time sales</div>
                </div>
            </div>
        </div>
    </div>

</div>

