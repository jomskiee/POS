@extends('layouts.admin')

@php
    $breadcrumbs = [
        ['title' => 'Fish Boxes Management']
    ];
@endphp

@section('content')
<div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Fish Boxes Management</h1>
                            <p class="text-gray-600 mt-2">Complete inventory control with fish boxes, fish types, fish boxes movement tracking</p>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-lg mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-8 px-4 md:px-6" aria-label="Tabs">
                            <a href="{{ route('admin.inventory.index') }}?tab=fishBoxes"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ ($currentTab ?? request('tab', 'fishBoxes')) === 'fishBoxes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-archive-box class="w-5 h-5" />
                                    <span>Fish Boxes</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.inventory.index') }}?tab=fishTypes"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ ($currentTab ?? request('tab')) === 'fishTypes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-tag class="w-5 h-5" />
                                    <span>Fish Types</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.inventory.index') }}?tab=movement"
                               class="whitespace-nowrap py-3 md:py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ ($currentTab ?? request('tab')) === 'movement' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-arrow-path class="w-5 h-5" />
                                    <span class="hidden lg:inline">Fish Boxes Movement Tracking</span>
                                    <span class="lg:hidden">Movement</span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    @if(($currentTab ?? request('tab', 'fishBoxes')) === 'fishBoxes')
                        @include('admin.inventory.fish-boxes')
                    @elseif(($currentTab ?? request('tab')) === 'fishTypes')
                        @include('admin.inventory.fish-types', ['fishTypes' => $fishTypes ?? collect()])
                    @elseif(($currentTab ?? request('tab')) === 'movement')
                        @include('admin.inventory.movement-tracking')
                    @endif
                </div>
            </div>
<!-- Inventory page specific JS -->
<script src="{{ asset('js/inventory.js') }}" defer></script>
<script src="{{ asset('js/qr-code.js') }}" defer></script>
@endsection
