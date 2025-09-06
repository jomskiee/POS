<!-- Broker Sidebar Component -->
<div :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-white min-h-screen shadow-lg transition-all duration-300 ease-in-out overflow-hidden">
    <div class="p-4 border-b">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-sm">POS</span>
            </div>
            <span x-show="sidebarOpen" x-transition class="text-xl font-bold text-gray-800 whitespace-nowrap">Broker Portal</span>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="mt-8 space-y-2">
        <!-- MENU Section -->
        <div class="space-y-1">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider transition-all duration-200"
                 :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                Menu
            </div>

            <!-- Dashboard -->
            <div>
                <a href="{{ route('broker.dashboard') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('broker.dashboard') ? 'bg-green-100 text-green-700 border-r-4 border-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('broker.dashboard') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Dashboard</span>
                </a>
            </div>
            
            <!-- Inventory & Stock -->
            <div>
                <a href="{{ route('broker.inventory.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('broker.inventory.*') ? 'bg-green-100 text-green-700 border-r-4 border-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('broker.inventory.*') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Inventory & Stock</span>
                </a>
            </div>
            
            <!-- Sales & Analytics -->
            <div>
                <a href="{{ route('broker.sales.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('broker.sales.*') ? 'bg-green-100 text-green-700 border-r-4 border-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('broker.sales.*') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Sales & Analytics</span>
                </a>
            </div>

        </div>
    </nav>
</div>