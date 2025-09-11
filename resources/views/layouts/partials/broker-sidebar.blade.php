<!-- Broker Sidebar Component -->
<div :class="sidebarOpen ? 'w-64' : 'w-16'" class="hidden md:block bg-white min-h-screen shadow-lg transition-all duration-300 ease-in-out overflow-hidden fixed left-0 top-0 z-40">
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
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider transition-all duration-200">
                Menu
            </div>

            <!-- Dashboard -->
            <div>
            <a href="{{ route('broker.dashboard') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('broker.dashboard') ? 'bg-green-100 text-green-700 border-r-4 border-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-squares-2x2 class="h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 sidebar-icon
                           {{ request()->routeIs('broker.dashboard') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                  <span class="transition-all duration-200" x-show="sidebarOpen" x-transition>Dashboard</span>
             </a>
         </div>

          <!-- Sales -->
          <div>
            <a href="{{ route('broker.sales.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('broker.sales.*') ? 'bg-green-100 text-green-700 border-r-4 border-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-shopping-cart class="h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 sidebar-icon
                           {{ request()->routeIs('broker.sales.*') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                  <span class="transition-all duration-200" x-show="sidebarOpen" x-transition>Sales</span>
             </a>
         </div>

         <!--  Analytics -->
         <div>
            <a href="{{ route('broker.sales.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('broker.sales.*') ? 'bg-green-100 text-green-700 border-r-4 border-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-chart-bar class="h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 sidebar-icon
                           {{ request()->routeIs('broker.sales.*') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                  <span class="transition-all duration-200" x-show="sidebarOpen" x-transition>Analytics</span>
             </a>
         </div>

     </div>
     </nav>
</div>
