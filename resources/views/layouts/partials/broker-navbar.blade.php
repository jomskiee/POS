<!-- Broker Navbar Component -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center space-x-4">
            <button @click="$dispatch('toggle-sidebar')" class="hidden md:block text-gray-500 hover:text-gray-700 transition-colors">
                <x-heroicon-o-bars-3 class="w-6 h-6" />
            </button>

            <!-- Mobile Title -->
            <div class="md:hidden">
                <h1 class="text-lg font-semibold text-gray-900">Broker Panel</h1>
            </div>

            <!-- Breadcrumbs -->
            <nav class="hidden md:block text-sm">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('broker.dashboard') }}" class="text-gray-500 hover:text-gray-700">Broker</a>
                    </li>
                    @if(isset($breadcrumbs) && !empty($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            <li>
                                <span class="text-gray-300">/</span>
                            </li>
                            <li>
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" class="text-gray-500 hover:text-gray-700">{{ $breadcrumb['title'] }}</a>
                                @else
                                    <span class="{{ $loop->last ? 'text-gray-900' : 'text-gray-700' }}">{{ $breadcrumb['title'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ol>
            </nav>
        </div>

        <div class="flex items-center space-x-4">
            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-gray-700 hover:text-gray-900 transition-colors">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                    <x-heroicon-o-chevron-down class="w-4 h-4" />
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
                            <div class="text-xs text-green-600 font-medium">Broker</div>
                        </div>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <x-heroicon-o-user class="w-4 h-4 mr-3" />
                            Profile
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <x-heroicon-o-chart-bar class="w-4 h-4 mr-3" />
                            My Sales
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <x-heroicon-o-cog-6-tooth class="w-4 h-4 mr-3" />
                            Settings
                        </a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 mr-3" />
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
