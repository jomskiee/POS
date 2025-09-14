<!-- Broker Mobile Footer Sidebar Component -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <div class="flex justify-around items-center py-2">
        <!-- Dashboard -->
        <div class="relative group">
            <a href="{{ route('broker.dashboard') }}"
               class="flex flex-col items-center justify-center p-2 rounded-lg transition-all duration-200 ease-in-out
                      {{ request()->routeIs('broker.dashboard') ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-squares-2x2 class="h-6 w-6 transition-transform duration-200 group-hover:scale-110
                           {{ request()->routeIs('broker.dashboard') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                <span class="text-xs mt-1 font-medium">Dashboard</span>
            </a>
            <!-- Tooltip -->
            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                Dashboard
                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
            </div>
        </div>

        <!-- Sales -->
        <div class="relative group">
            <a href="{{ route('broker.sales.sales') }}"
               class="flex flex-col items-center justify-center p-2 rounded-lg transition-all duration-200 ease-in-out
                      {{ request()->routeIs('broker.sales.sales') ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-banknotes class="h-6 w-6 transition-transform duration-200 group-hover:scale-110
                           {{ request()->routeIs('broker.sales.sales') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                <span class="text-xs mt-1 font-medium">Sales</span>
            </a>
            <!-- Tooltip -->
            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                Sales
                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
            </div>
        </div>

        <!-- Fish Boxes -->
        <div>
                <a href="{{ route('broker.sales.fish-boxes') }}"
               class="flex flex-col items-center justify-center p-2 rounded-lg transition-all duration-200 ease-in-out
                      {{ request()->routeIs('broker.sales.fish-boxes') ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <x-heroicon-o-cube class="h-6 w-6 transition-transform duration-200 group-hover:scale-110
                           {{ request()->routeIs('broker.sales.fish-boxes') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                    <span class="text-xs mt-1 font-medium">Fish Boxes</span>
                </a>
            <!-- Tooltip -->
            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                Fish Boxes
                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
            </div>
        </div>

        <!-- Analytics -->
        <div class="relative group">
            <a href="{{ route('broker.sales.analytics') }}"
               class="flex flex-col items-center justify-center p-2 rounded-lg transition-all duration-200 ease-in-out
                      {{ request()->routeIs('broker.sales.analytics') ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-chart-bar class="h-6 w-6 transition-transform duration-200 group-hover:scale-110
                           {{ request()->routeIs('broker.sales.analytics') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                <span class="text-xs mt-1 font-medium">Analytics</span>
            </a>
            <!-- Tooltip -->
            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                Analytics
                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
            </div>
        </div>

    </div>

    <!-- Copyright Footer -->
    <div class="border-t border-gray-200 bg-gray-50 px-4 py-2">
        <div class="flex items-center justify-center text-xs text-gray-500">
            <span class="mr-1">Copyright ©</span>
            <span>2025 <span class="font-bold text-green-600">J & J Devz</span>, All rights reserved.</span>
        </div>
    </div>
</div>
