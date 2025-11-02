<div>
    <!-- Fish Types Tab Content -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Fish Types List</h2>
        <a href="{{ route('broker.inventory.index', ['tab' => 'fishTypes', 'modal' => 'create']) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
            <x-heroicon-o-plus class="w-4 h-4" />
            <span>Add Fish Type</span>
        </a>
    </div>

    <!-- Fish Type Modal (Create/Edit) -->
    @if(request('modal') === 'create' || request('modal') === 'edit')
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                <!-- Modal Header -->
                <div class="bg-white px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <x-heroicon-o-tag class="w-5 h-5 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ request('modal') === 'edit' ? 'Edit Fish Type' : 'Add New Fish Type' }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ request('modal') === 'edit' ? 'Update the fish type details' : 'Enter the details for the new fish type' }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('broker.inventory.index', ['tab' => 'fishTypes']) }}"
                           class="text-gray-400 hover:text-gray-600 transition-colors">
                            <x-heroicon-o-x-mark class="w-6 h-6" />
                        </a>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="bg-white px-6 py-6">
                    <form action="{{ request('modal') === 'edit' ? route('broker.fish-types.update', request('edit')) : route('broker.fish-types.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if(request('modal') === 'edit')
                            @method('PUT')
                        @endif

                        <!-- Fish Type Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Fish Type Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ request('modal') === 'edit' && isset($editingFishType) ? $editingFishType->name : old('name') }}"
                                       placeholder="Enter fish type name (e.g., Tilapia, Catfish)"
                                       class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('name') border-red-500 @enderror"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-tag class="h-5 w-5 text-gray-400" />
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Enter a detailed description of the fish type..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none @error('description') border-red-500 @enderror">{{ request('modal') === 'edit' && isset($editingFishType) ? $editingFishType->description : old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 pt-4">
                            <a href="{{ route('broker.inventory.index', ['tab' => 'fishTypes']) }}"
                               class="mt-3 w-full inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="w-full inline-flex justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto transition-colors">
                                @if(request('modal') === 'edit')
                                    <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                                    Update Fish Type
                                @else
                                    <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                                    Add Fish Type
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Fish Types Search -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('broker.inventory.index') }}" x-data="{ search: '{{ request('search') }}' }">
            <input type="hidden" name="tab" value="fishTypes">
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text"
                            name="search"
                            x-model="search"
                            placeholder="Search fish types..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('broker.inventory.index', ['tab' => 'fishTypes']) }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Clear
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if($fishTypes->hasPages() || request()->has('search'))
        <div class="mb-4">
            <p class="text-sm text-gray-600">
                Showing {{ $fishTypes->firstItem() ?? 0 }} to {{ $fishTypes->lastItem() ?? 0 }} of {{ $fishTypes->total() }} fish types
                @if(request()->has('search'))
                    <span class="text-green-600">(filtered)</span>
                @endif
            </p>
        </div>
    @endif

    <!-- Fish Types Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fish Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($fishTypes as $fishType)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                        <x-heroicon-o-tag class="w-5 h-5 text-white" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $fishType->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900">{{ $fishType->description }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('broker.inventory.index', ['tab' => 'fishTypes', 'modal' => 'edit', 'edit' => $fishType->id]) }}"
                                       class="text-green-600 hover:text-green-900 transition-colors">
                                        <x-heroicon-o-pencil-square class="w-6 h-6" />
                                    </a>
                                    @if($fishType->isUsed())
                                        <button type="button" class="text-gray-400 cursor-not-allowed" title="Cannot delete: Fish type is in use">
                                            <x-heroicon-o-trash class="w-6 h-6" />
                                        </button>
                                    @else
                                        <form action="{{ route('broker.fish-types.destroy', $fishType->id) }}" method="POST" class="inline" data-swal="delete" data-record-name="{{ $fishType->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                                <x-heroicon-o-trash class="w-6 h-6" />
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No fish types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($fishTypes->hasPages())
        <div class="mt-8">
            {{ $fishTypes->appends(request()->query())->links('components.pagination') }}
        </div>
    @endif
</div>
