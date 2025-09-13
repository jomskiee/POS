<!-- Admin Sidebar Component -->
<div :class="sidebarOpen ? 'w-64' : 'w-16'" class="hidden md:block bg-white min-h-screen shadow-lg transition-all duration-300 ease-in-out overflow-hidden fixed left-0 top-0 z-40">
    <div class="p-4 border-b">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-sm">POS</span>
            </div>
            <span x-show="sidebarOpen" x-transition class="text-xl font-bold text-gray-800 whitespace-nowrap">Point of Sale</span>
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
            <a href="{{ route('admin.dashboard') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-squares-2x2 class="h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 sidebar-icon
                           {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                  <span class="transition-all duration-200" x-show="sidebarOpen" x-transition>Dashboard</span>
             </a>
         </div>

         <!-- User Management -->
         <div>
            <a href="{{ route('admin.users.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-users class="h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 sidebar-icon
                           {{ request()->routeIs('admin.users.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                  <span class="transition-all duration-200" x-show="sidebarOpen" x-transition>User Management</span>
             </a>
         </div>

         <!-- Fish Boxes Management -->
         <div>
            <a href="{{ route('admin.inventory.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('admin.inventory.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-cube class="h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 sidebar-icon
                           {{ request()->routeIs('admin.inventory.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                  <span class="transition-all duration-200" x-show="sidebarOpen" x-transition>Fish Boxes Management</span>
             </a>
         </div>

         <!-- Sales & Analytics -->
         <div>
            <a href="{{ route('admin.sales.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('admin.sales.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <x-heroicon-o-chart-bar class="h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 sidebar-icon
                           {{ request()->routeIs('admin.sales.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" />
                  <span class="transition-all duration-200" x-show="sidebarOpen" x-transition>Sales & Analytics</span>
             </a>
         </div>
     </div>
     </nav>
</div>
