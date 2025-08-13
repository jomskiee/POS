@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex" x-data="{ sidebarOpen: true, reportsOpen: false }">
    <!-- Sidebar -->
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
        <nav class="mt-6">
            <div x-show="sidebarOpen" x-transition class="px-4 pb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</p>
            </div>
            
            <ul class="space-y-1 px-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Dashboard</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-blue-600 bg-blue-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">User Management</span>
                    </a>
                </li>
                
                <li>
                    <a href="#" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group relative">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Product Management</span>
                    </a>
                </li>
                

                
                <!-- Reports with Submenu -->
                <li>
                    <div>
                        <button @click="reportsOpen = !reportsOpen" 
                                class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group relative">
                            <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span x-show="sidebarOpen" x-transition class="flex-1 text-left whitespace-nowrap">Reports</span>
                            <svg x-show="sidebarOpen" :class="reportsOpen ? 'rotate-90' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        
                        <!-- Reports Submenu -->
                        <div x-show="sidebarOpen && reportsOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="mt-2 space-y-1">
                            <a href="{{ route('admin.reports.daily-sales') }}" 
                               class="flex items-center pl-11 pr-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Daily Sales Report
                            </a>
                            
                            <a href="{{ route('admin.reports.order-history') }}" 
                               class="flex items-center pl-11 pr-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Order List History
                            </a>
                            
                            <a href="{{ route('admin.reports.supplies-list') }}" 
                               class="flex items-center pl-11 pr-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                Recent Supplies List
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- Breadcrumbs -->
                    <nav class="text-sm">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Admin</a>
                            </li>
                            <li>
                                <span class="text-gray-300">/</span>
                            </li>
                            <li>
                                <span class="text-gray-900">User Management</span>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- POS Terminal Button - Hidden on mobile, visible on md+ screens -->
                    <a href="{{ route('pos.terminal') }}" class="hidden md:inline-flex bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                        POS Terminal
                    </a>
                    
                    <!-- Notifications -->
                    <button class="text-gray-500 hover:text-gray-700 relative transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-6h4v6z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-sm text-gray-700 hover:text-gray-900 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <div class="py-1">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <div class="font-medium">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6" x-data="userManagement()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                            <p class="text-gray-600 mt-2">Manage system users and their permissions</p>
                        </div>
                        <button @click="openAddModal()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Add User</span>
                        </button>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">All Users</h3>
                            <div class="flex items-center space-x-4">
                                <!-- Search -->
                                <div class="relative">
                                    <input type="text" 
                                           x-model="searchQuery"
                                           placeholder="Search users..." 
                                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Filter -->
                                <select x-model="roleFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <template x-for="user in filteredUsers" :key="user.id">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-medium"
                                                     :class="user.role === 'admin' ? 'bg-purple-500' : 'bg-blue-500'">
                                                    <span x-text="user.name.charAt(0).toUpperCase()"></span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900" x-text="user.name"></div>
                                                    <div class="text-sm text-gray-500" x-text="user.email"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900" x-text="user.email"></div>
                                            <div class="text-sm text-gray-500" x-text="user.address"></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                  :class="user.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'"
                                                  x-text="user.role.charAt(0).toUpperCase() + user.role.slice(1)"></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="user.joined"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <button @click="openEditModal(user)" 
                                                        class="text-blue-600 hover:text-blue-900 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button @click="deleteUser(user.id)" 
                                                        class="text-red-600 hover:text-red-900 transition-colors"
                                                        :disabled="user.id === currentUserId">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add User Modal -->
            <div x-show="showAddModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeAddModal()">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Add New User</h3>
                        <button @click="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="addUser()">
                        <div class="space-y-4">
                            <div>
                                <label for="add_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" 
                                       id="add_name"
                                       x-model="addForm.name" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div x-show="addForm.errors.name" class="text-red-500 text-xs mt-1" x-text="addForm.errors.name"></div>
                            </div>
                            
                            <div>
                                <label for="add_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" 
                                       id="add_email"
                                       x-model="addForm.email" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div x-show="addForm.errors.email" class="text-red-500 text-xs mt-1" x-text="addForm.errors.email"></div>
                            </div>
                            
                            <div>
                                <label for="add_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea id="add_address"
                                          x-model="addForm.address" 
                                          required
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                <div x-show="addForm.errors.address" class="text-red-500 text-xs mt-1" x-text="addForm.errors.address"></div>
                            </div>
                            
                            <div>
                                <label for="add_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select id="add_role"
                                        x-model="addForm.role" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="employee">Employee</option>
                                </select>
                                <div x-show="addForm.errors.role" class="text-red-500 text-xs mt-1" x-text="addForm.errors.role"></div>
                            </div>
                            
                            <div>
                                <label for="add_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input type="password" 
                                       id="add_password"
                                       x-model="addForm.password" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div x-show="addForm.errors.password" class="text-red-500 text-xs mt-1" x-text="addForm.errors.password"></div>
                            </div>
                            
                            <div>
                                <label for="add_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" 
                                       id="add_password_confirmation"
                                       x-model="addForm.password_confirmation" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" 
                                    @click="closeAddModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    :disabled="addForm.loading"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors disabled:opacity-50">
                                <span x-show="!addForm.loading">Add User</span>
                                <span x-show="addForm.loading">Adding...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit User Modal -->
            <div x-show="showEditModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                 @click.self="closeEditModal()">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit User</h3>
                        <button @click="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="updateUser()">
                        <div class="space-y-4">
                            <div>
                                <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" 
                                       id="edit_name"
                                       x-model="editForm.name" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div x-show="editForm.errors.name" class="text-red-500 text-xs mt-1" x-text="editForm.errors.name"></div>
                            </div>
                            
                            <div>
                                <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" 
                                       id="edit_email"
                                       x-model="editForm.email" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div x-show="editForm.errors.email" class="text-red-500 text-xs mt-1" x-text="editForm.errors.email"></div>
                            </div>
                            
                            <div>
                                <label for="edit_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea id="edit_address"
                                          x-model="editForm.address" 
                                          required
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                <div x-show="editForm.errors.address" class="text-red-500 text-xs mt-1" x-text="editForm.errors.address"></div>
                            </div>
                            
                            <div>
                                <label for="edit_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select id="edit_role"
                                        x-model="editForm.role" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="employee">Employee</option>
                                </select>
                                <div x-show="editForm.errors.role" class="text-red-500 text-xs mt-1" x-text="editForm.errors.role"></div>
                            </div>
                            
                            <div>
                                <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-1">New Password (leave blank to keep current)</label>
                                <input type="password" 
                                       id="edit_password"
                                       x-model="editForm.password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div x-show="editForm.errors.password" class="text-red-500 text-xs mt-1" x-text="editForm.errors.password"></div>
                            </div>
                            
                            <div x-show="editForm.password">
                                <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" 
                                       id="edit_password_confirmation"
                                       x-model="editForm.password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" 
                                    @click="closeEditModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    :disabled="editForm.loading"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors disabled:opacity-50">
                                <span x-show="!editForm.loading">Update User</span>
                                <span x-show="editForm.loading">Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function userManagement() {
    return {
        // State
        searchQuery: '',
        roleFilter: '',
        showAddModal: false,
        showEditModal: false,
        currentUserId: {{ auth()->id() }},
        
        // Dummy users data
        users: [
            {
                id: 1,
                name: 'John Administrator',
                email: 'admin@mail.com',
                address: '123 Main Street, Downtown City, State 12345',
                role: 'admin',
                joined: '2024-01-15'
            },
            {
                id: 2,
                name: 'Jane Employee',
                email: 'employee@mail.com',
                address: '456 Oak Avenue, Suburb Town, State 67890',
                role: 'employee',
                joined: '2024-02-20'
            },
            {
                id: 3,
                name: 'Mike Johnson',
                email: 'mike.johnson@mail.com',
                address: '789 Pine Road, Industrial Area, State 11111',
                role: 'employee',
                joined: '2024-03-10'
            },
            {
                id: 4,
                name: 'Sarah Wilson',
                email: 'sarah.wilson@mail.com',
                address: '321 Elm Street, Residential Zone, State 22222',
                role: 'admin',
                joined: '2024-01-30'
            },
            {
                id: 5,
                name: 'David Brown',
                email: 'david.brown@mail.com',
                address: '654 Cedar Lane, Business District, State 33333',
                role: 'employee',
                joined: '2024-04-05'
            },
            {
                id: 6,
                name: 'Lisa Davis',
                email: 'lisa.davis@mail.com',
                address: '987 Maple Drive, Shopping Center, State 44444',
                role: 'employee',
                joined: '2024-04-15'
            }
        ],
        
        // Form data
        addForm: {
            name: '',
            email: '',
            address: '',
            role: '',
            password: '',
            password_confirmation: '',
            loading: false,
            errors: {}
        },
        
        editForm: {
            id: null,
            name: '',
            email: '',
            address: '',
            role: '',
            password: '',
            password_confirmation: '',
            loading: false,
            errors: {}
        },
        
        // Computed
        get filteredUsers() {
            let filtered = this.users;
            
            // Filter by search query
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(user => 
                    user.name.toLowerCase().includes(query) || 
                    user.email.toLowerCase().includes(query)
                );
            }
            
            // Filter by role
            if (this.roleFilter) {
                filtered = filtered.filter(user => user.role === this.roleFilter);
            }
            
            return filtered;
        },
        
        // Methods
        openAddModal() {
            this.showAddModal = true;
            this.resetAddForm();
        },
        
        closeAddModal() {
            this.showAddModal = false;
            this.resetAddForm();
        },
        
        openEditModal(user) {
            this.editForm.id = user.id;
            this.editForm.name = user.name;
            this.editForm.email = user.email;
            this.editForm.address = user.address;
            this.editForm.role = user.role;
            this.editForm.password = '';
            this.editForm.password_confirmation = '';
            this.editForm.errors = {};
            this.showEditModal = true;
        },
        
        closeEditModal() {
            this.showEditModal = false;
            this.resetEditForm();
        },
        
        resetAddForm() {
            this.addForm = {
                name: '',
                email: '',
                address: '',
                role: '',
                password: '',
                password_confirmation: '',
                loading: false,
                errors: {}
            };
        },
        
        resetEditForm() {
            this.editForm = {
                id: null,
                name: '',
                email: '',
                address: '',
                role: '',
                password: '',
                password_confirmation: '',
                loading: false,
                errors: {}
            };
        },
        
        async addUser() {
            this.addForm.loading = true;
            this.addForm.errors = {};
            
            try {
                // Simulate API call for now
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Add to dummy data
                const newUser = {
                    id: this.users.length + 1,
                    name: this.addForm.name,
                    email: this.addForm.email,
                    address: this.addForm.address,
                    role: this.addForm.role,
                    joined: new Date().toISOString().split('T')[0]
                };
                
                this.users.push(newUser);
                this.closeAddModal();
                
                // Show success message (you can implement toast notifications)
                alert('User added successfully!');
                
            } catch (error) {
                console.error('Error adding user:', error);
                alert('Failed to add user. Please try again.');
            } finally {
                this.addForm.loading = false;
            }
        },
        
        async updateUser() {
            this.editForm.loading = true;
            this.editForm.errors = {};
            
            try {
                // Simulate API call for now
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Update dummy data
                const userIndex = this.users.findIndex(u => u.id === this.editForm.id);
                if (userIndex !== -1) {
                    this.users[userIndex] = {
                        ...this.users[userIndex],
                        name: this.editForm.name,
                        email: this.editForm.email,
                        address: this.editForm.address,
                        role: this.editForm.role
                    };
                }
                
                this.closeEditModal();
                
                // Show success message
                alert('User updated successfully!');
                
            } catch (error) {
                console.error('Error updating user:', error);
                alert('Failed to update user. Please try again.');
            } finally {
                this.editForm.loading = false;
            }
        },
        
        async deleteUser(userId) {
            if (userId === this.currentUserId) {
                alert('You cannot delete your own account.');
                return;
            }
            
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                return;
            }
            
            try {
                // Simulate API call for now
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // Remove from dummy data
                this.users = this.users.filter(u => u.id !== userId);
                
                // Show success message
                alert('User deleted successfully!');
                
            } catch (error) {
                console.error('Error deleting user:', error);
                alert('Failed to delete user. Please try again.');
            }
        }
    }
}
</script>
@endsection