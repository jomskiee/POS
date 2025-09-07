<!-- Admin Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Admins Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Admins</p>
                <p class="text-2xl font-bold text-gray-900">{{ $count['totalAdmins'] }}</p>
            </div>
        </div>
    </div>

    <!-- Active Admins Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Active Admins</p>
                <p class="text-2xl font-bold text-gray-900">{{ $count['activeAdmins'] }}</p>
            </div>
        </div>
    </div>

    <!-- Deactivated Admins Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Deactivated Admins</p>
                <p class="text-2xl font-bold text-gray-900">{{ $count['deactivatedAdmins'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Admin List Tab Content -->
<div class="space-y-4">
    <!-- Admin Users Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Admin Users</h3>
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
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-medium text-sm bg-blue-500">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.users.edit', $admin->user->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors">Edit</a>

                                @if($admin->status === 'active')
                                    <form method="POST" action="{{ route('admin.users.deactivate', $admin->user->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-orange-600 hover:text-orange-900 transition-colors {{ $admin->user->id === auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $admin->user->id === auth()->id() ? 'disabled' : '' }}
                                                onclick="{{ $admin->user->id === auth()->id() ? 'return false;' : "return confirm('Are you sure you want to deactivate this admin?')" }}">
                                            Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.users.activate', $admin->user->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900 transition-colors" onclick="return confirm('Are you sure you want to activate this admin?')">
                                            Activate
                                        </button>
                                    </form>
                                @endif
                            </td>
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
