<!-- Admin Sidebar Component -->
<div :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-white min-h-screen shadow-lg transition-all duration-300 ease-in-out overflow-hidden">
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
                <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider transition-all duration-200"
                     :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                    Menu
                </div>

                <!-- Dashboard -->
                <div>
                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z"></path>
                                         </svg>
                     <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Dashboard</span>
                 </a>
             </div>

             <!-- Inventory & Stock -->
             <div>
                <a href="{{ route('admin.inventory.index') }}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('admin.inventory.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('admin.inventory.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                         </svg>
                     <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Inventory & Stock</span>
                 </a>
             </div>

             <!-- Purchase & Procurement -->
             <div>
                <a href="{{ route('admin.purchase-orders.index') }}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('admin.purchase-orders.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('admin.purchase-orders.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                         </svg>
                     <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Purchase & Procurement</span>
                 </a>
             </div>
         </div>

         <!-- FINANCES Section -->
         <div class="space-y-1 pt-4">
             <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider transition-all duration-200"
                  :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                 Finances
             </div>

             <!-- Sales & Analytics -->
             <div>
                <a href="{{ route('admin.sales.index') }}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('admin.sales.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('admin.sales.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                         </svg>
                     <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Sales & Analytics</span>
                 </a>
             </div>

             <!-- Account & Finance -->
             <div>
                <a href="{{ route('admin.accounting.index') }}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('admin.accounting.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('admin.accounting.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                         </svg>
                     <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Account & Finance</span>
                 </a>
             </div>
         </div>

         <!-- User Management -->
         <div>
            <a href="{{ route('admin.users.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                      {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                           {{ request()->routeIs('admin.users.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                 </svg>
                 <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">User Management</span>
             </a>
         </div>

         <!-- SETTINGS Section -->
         <div class="space-y-1 pt-4">
             <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider transition-all duration-200"
                  :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                 Settings
             </div>

             <!-- Digital Integration -->
             <div>
                 <a href="{{ route('admin.digital-integration.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                           {{ request()->routeIs('admin.digital-integration.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                     <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                                {{ request()->routeIs('admin.digital-integration.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                          fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                           </svg>
                      <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Digital Integration</span>
                  </a>
              </div>

             <!-- System Settings -->
             <div>
                <a href="{{ route('admin.settings.index') }}"
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                          {{ request()->routeIs('admin.settings.*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110
                               {{ request()->routeIs('admin.settings.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                         </svg>
                     <span class="transition-all duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">System Settings</span>
                 </a>
             </div>
         </div>
     </nav>
</div>