@extends('layouts.admin')

@php
    $breadcrumbs = [
        ['title' => 'User Management']
    ];
@endphp

@section('content')
<div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                            <p class="text-gray-600 mt-2">Manage system users such as LEEO and brokers.</p>
                        </div>
                        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2">
                            <x-heroicon-o-plus class="w-5 h-5" />
                            Add User
                        </a>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-lg mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-8 px-4 md:px-6" aria-label="Tabs">
                            <a href="{{ route('admin.users.index') }}?tab=admins"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('tab', 'admins') === 'admins' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-users class="w-5 h-5" />
                                    <span>LEEO ({{ $admins->count() }})</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.users.index') }}?tab=brokers"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('tab') === 'brokers' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-user-group class="w-5 h-5" />
                                    <span>Brokers ({{ $brokers->whereNull('deleted_at')->count() }})</span>
                                </div>
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

<!-- Users page specific JS -->
<script src="{{ asset('js/user.js') }}" defer></script>
@endsection
