<!-- Admin Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
    <!-- Total Admins Card -->
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-blue-100">
                <x-heroicon-o-users class="w-5 h-5 md:w-6 md:h-6 text-blue-600" />
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Total LEEO</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $count['totalAdmins'] }}</p>
            </div>
        </div>
    </div>

    <!-- Active Admins Card -->
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-green-100">
                <x-heroicon-o-check-circle class="w-5 h-5 md:w-6 md:h-6 text-green-600" />
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Active LEEO</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $count['activeAdmins'] }}</p>
            </div>
        </div>
    </div>

    <!-- Deactivated Admins Card -->
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-red-100">
                <x-heroicon-o-x-circle class="w-5 h-5 md:w-6 md:h-6 text-red-600" />
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Deactivated LEEO</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $count['deactivatedAdmins'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Admin List Tab Content -->
<div class="space-y-4">
    <!-- Admin Users Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">LEEO Users</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-medium text-sm bg-blue-500">
                                        <span>{{ substr($admin->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $admin->address }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $admin->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $admin->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $admin->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"><div class="flex items-center gap-2">
                                <span class="relative group inline-block">
                                    <a href="{{ route('admin.users.edit', $admin->user->id) }}" class="p-2 rounded-full hover:bg-gray-100 text-blue-600 hover:text-blue-800 transition-colors" aria-label="Edit">
                                        <x-heroicon-o-pencil-square class="w-6 h-6" />
                                    </a>
                                    <span class="absolute -top-8 left-1/2 -translate-x-1/2 whitespace-nowrap bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Edit</span>
                                </span>

                                @if($admin->status === 'active')
                                    <form method="POST" action="{{ route('admin.users.deactivate', $admin->user->id) }}" class="inline" data-swal="deactivate">
                                        @csrf
                                        @method('PATCH')
                                        <span class="relative group inline-block">
                                            <button type="submit"
                                                    class="p-2 rounded-full hover:bg-gray-100 text-orange-600 hover:text-orange-800 transition-colors {{ $admin->user->id === auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ $admin->user->id === auth()->id() ? 'disabled' : '' }}
                                                    aria-label="Deactivate">
                                                <x-heroicon-o-user-minus class="w-6 h-6" />
                                            </button>
                                            <span class="absolute -top-8 left-1/2 -translate-x-1/2 whitespace-nowrap bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Deactivate</span>
                                        </span>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.users.activate', $admin->user->id) }}" class="inline" data-swal="activate">
                                        @csrf
                                        @method('PATCH')
                                        <span class="relative group inline-block">
                                            <button type="submit" class="p-2 rounded-full hover:bg-gray-100 text-green-600 hover:text-green-800 transition-colors" aria-label="Activate">
                                                <x-heroicon-o-user-plus class="w-6 h-6" />
                                            </button>
                                            <span class="absolute -top-8 left-1/2 -translate-x-1/2 whitespace-nowrap bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Activate</span>
                                        </span>
                                    </form>
                                @endif
                            </div></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No admin users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
