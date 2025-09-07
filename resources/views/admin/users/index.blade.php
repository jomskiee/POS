@extends('layouts.app')

@section('content')
@php
    $breadcrumbs = [
        ['title' => 'User Management']
    ];
@endphp

<div class="min-h-screen bg-gray-50 flex" x-data="{ sidebarOpen: true, reportsOpen: false }">
    <!-- Sidebar Component -->
    @include('layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Navbar Component -->
        @include('layouts.partials.navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                            <p class="text-gray-600 mt-2">Manage system users such as admin and brokers.</p>
                        </div>
                        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add User
                        </a>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-lg mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <a href="{{ route('admin.users.index') }}?tab=admins" 
                               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('tab', 'admins') === 'admins' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Admins ({{ $admins->count() }})
                            </a>
                            <a href="{{ route('admin.users.index') }}?tab=brokers" 
                               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('tab') === 'brokers' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Brokers ({{ $brokers->whereNull('deleted_at')->count() }})
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    @if(request('tab', 'admins') === 'admins')
                        @include('admin.users.admin-list', ['admins' => $admins])
                    @else
                        @include('admin.users.broker-list', ['brokers' => $brokers])
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
