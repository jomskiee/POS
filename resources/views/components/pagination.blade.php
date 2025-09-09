@if ($paginator->hasPages())
    <nav class="flex items-center justify-between px-4 py-6">
        <div class="flex flex-1 justify-between sm:hidden">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                    <x-heroicon-o-chevron-left class="h-4 w-4 mr-2" />
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                    <x-heroicon-o-chevron-left class="h-4 w-4 mr-2" />
                    Previous
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                    Next
                    <x-heroicon-o-chevron-right class="h-4 w-4 ml-2" />
                </a>
            @else
                <span class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                    Next
                    <x-heroicon-o-chevron-right class="h-4 w-4 ml-2" />
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-500">
                    Showing
                    <span class="font-medium text-gray-900">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium text-gray-900">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium text-gray-900">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="flex items-center space-x-1" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            <span class="sr-only">Previous</span>
                            <x-heroicon-o-chevron-left class="h-4 w-4" />
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                            <span class="sr-only">Previous</span>
                            <x-heroicon-o-chevron-left class="h-4 w-4" />
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-blue-600 border-b-2 border-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                            <span class="sr-only">Next</span>
                            <x-heroicon-o-chevron-right class="h-4 w-4" />
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            <span class="sr-only">Next</span>
                            <x-heroicon-o-chevron-right class="h-4 w-4" />
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </nav>
@endif
