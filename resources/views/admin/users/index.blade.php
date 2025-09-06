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
        <main class="flex-1 overflow-auto p-6" x-data="userManagement()">
            <div class="w-full">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                            <p class="text-gray-600 mt-2">Manage system users such as admin and brokers.</p>
                        </div>
                        <button @click="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add User
                        </button>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-lg mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <button @click="activeTab = 'admins'"
                                    :class="activeTab === 'admins' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Admins (<span x-text="filteredAdmins().length"></span>)
                            </button>
                            <button @click="activeTab = 'brokers'"
                                    :class="activeTab === 'brokers' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Brokers (<span x-text="filteredBrokers().length"></span>)
                            </button>
                        </nav>
                    </div>
                </div>
                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Admin List Tab -->
                    <div x-show="activeTab === 'admins'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @include('admin.users.admin-list')
                    </div>

                    <!-- Broker List Tab -->
                    <div x-show="activeTab === 'brokers'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @include('admin.users.broker-list')
                    </div>
                </div>

                <!-- Add User Modal -->
                <div x-show="showAddModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Add New User</h3>
                                <button @click="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form @submit.prevent="addUser()">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" x-model="addForm.name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        <span x-show="addForm.errors.name" class="text-red-500 text-xs" x-text="addForm.errors.name"></span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" x-model="addForm.email" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        <span x-show="addForm.errors.email" class="text-red-500 text-xs" x-text="addForm.errors.email"></span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea x-model="addForm.address" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="2"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Role</label>
                                        <select x-model="addForm.role" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            <option value="">Select Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="broker">Broker</option>
                                        </select>
                                        <span x-show="addForm.errors.role" class="text-red-500 text-xs" x-text="addForm.errors.role"></span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Password</label>
                                        <input type="password" x-model="addForm.password" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        <span x-show="addForm.errors.password" class="text-red-500 text-xs" x-text="addForm.errors.password"></span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                        <input type="password" x-model="addForm.password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button type="button" @click="closeAddModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                                        Add User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit User Modal -->
                <div x-show="showEditModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Edit User</h3>
                                <button @click="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form @submit.prevent="updateUser()">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" x-model="editForm.name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        <span x-show="editForm.errors.name" class="text-red-500 text-xs" x-text="editForm.errors.name"></span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" x-model="editForm.email" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        <span x-show="editForm.errors.email" class="text-red-500 text-xs" x-text="editForm.errors.email"></span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea x-model="editForm.address" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="2"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Role</label>
                                        <select x-model="editForm.role" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            <option value="admin">Admin</option>
                                            <option value="broker">Broker</option>
                                        </select>
                                        <span x-show="editForm.errors.role" class="text-red-500 text-xs" x-text="editForm.errors.role"></span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                                        <input type="password" x-model="editForm.password" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <span x-show="editForm.errors.password" class="text-red-500 text-xs" x-text="editForm.errors.password"></span>
                                    </div>
                                    <div x-show="editForm.password">
                                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                        <input type="password" x-model="editForm.password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button type="button" @click="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                                        Update User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function userManagement() {
    return {
        activeTab: 'admins',
        searchQuery: '',
        roleFilter: '',
        showAddModal: false,
        showEditModal: false,
        currentUserId: {{ auth()->id() }},
        users: [
            {
                id: 1,
                name: 'John Admin',
                email: 'admin@example.com',
                address: '123 Main St, City, State',
                role: 'admin',
                created_at: '2024-01-15'
            },
            {
                id: 2,
                name: 'Jane Broker',
                email: 'jane@example.com',
                address: '456 Oak Ave, City, State',
                role: 'broker',
                created_at: '2024-02-10'
            },
            {
                id: 3,
                name: 'Mike Broker',
                email: 'mike@example.com',
                address: '789 Pine Rd, City, State',
                role: 'broker',
                created_at: '2024-03-05'
            },
            {
                id: 4,
                name: 'Sarah Manager',
                email: 'sarah@example.com',
                address: '321 Elm St, City, State',
                role: 'admin',
                created_at: '2024-01-20'
            },
            {
                id: 5,
                name: 'Alex Broker',
                email: 'alex@example.com',
                address: '654 Maple Dr, City, State',
                role: 'broker',
                created_at: '2024-03-12'
            },
            {
                id: 6,
                name: 'Lisa Broker',
                email: 'lisa@example.com',
                address: '987 Cedar Ln, City, State',
                role: 'broker',
                created_at: '2024-03-18'
            }
        ],
        addForm: {
            name: '',
            email: '',
            address: '',
            role: '',
            password: '',
            password_confirmation: '',
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
            errors: {}
        },

        filteredUsers() {
            return this.users.filter(user => {
                const matchesSearch = user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                    user.email.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesRole = this.roleFilter === '' || user.role === this.roleFilter;
                return matchesSearch && matchesRole;
            });
        },

        filteredAdmins() {
            return this.users.filter(user => {
                const matchesSearch = user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                    user.email.toLowerCase().includes(this.searchQuery.toLowerCase());
                return user.role === 'admin' && matchesSearch;
            });
        },

        filteredBrokers() {
            return this.users.filter(user => {
                const matchesSearch = user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                    user.email.toLowerCase().includes(this.searchQuery.toLowerCase());
                return user.role === 'broker' && matchesSearch;
            });
        },

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
                errors: {}
            };
        },

        async addUser() {
            // Reset errors
            this.addForm.errors = {};

            // Basic validation
            if (!this.addForm.name) this.addForm.errors.name = 'Name is required';
            if (!this.addForm.email) this.addForm.errors.email = 'Email is required';
            if (!this.addForm.role) this.addForm.errors.role = 'Role is required';
            if (!this.addForm.password) this.addForm.errors.password = 'Password is required';
            if (this.addForm.password !== this.addForm.password_confirmation) {
                this.addForm.errors.password = 'Passwords do not match';
            }

            if (Object.keys(this.addForm.errors).length > 0) return;

            // Simulate adding user (in real app, this would be an API call)
            const newUser = {
                id: this.users.length + 1,
                name: this.addForm.name,
                email: this.addForm.email,
                address: this.addForm.address,
                role: this.addForm.role,
                created_at: new Date().toISOString().split('T')[0]
            };

            this.users.push(newUser);
            this.closeAddModal();

            // Show success message (you could implement a toast notification)
            alert('User added successfully!');
        },

        async updateUser() {
            // Reset errors
            this.editForm.errors = {};

            // Basic validation
            if (!this.editForm.name) this.editForm.errors.name = 'Name is required';
            if (!this.editForm.email) this.editForm.errors.email = 'Email is required';
            if (!this.editForm.role) this.editForm.errors.role = 'Role is required';
            if (this.editForm.password && this.editForm.password !== this.editForm.password_confirmation) {
                this.editForm.errors.password = 'Passwords do not match';
            }

            if (Object.keys(this.editForm.errors).length > 0) return;

            // Simulate updating user (in real app, this would be an API call)
            const userIndex = this.users.findIndex(user => user.id === this.editForm.id);
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

            // Show success message (you could implement a toast notification)
            alert('User updated successfully!');
        },

        async deleteUser(userId) {
            if (userId === this.currentUserId) {
                alert('You cannot delete your own account!');
                return;
            }

            if (confirm('Are you sure you want to delete this user?')) {
                // Simulate deleting user (in real app, this would be an API call)
                this.users = this.users.filter(user => user.id !== userId);

                // Show success message (you could implement a toast notification)
                alert('User deleted successfully!');
            }
        },

        viewPerformance(user) {
            alert(`Viewing performance for ${user.name}:\n\nTotal Sales: $${Math.floor(Math.random() * 10000) + 5000}\nOrders Processed: ${Math.floor(Math.random() * 500) + 100}\nCustomer Rating: ${(Math.random() * 2 + 3).toFixed(1)}/5.0`);
        }
    }
}
</script>
@endsection