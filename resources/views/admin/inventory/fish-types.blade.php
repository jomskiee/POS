<div x-data="fishTypeManagement()">
    <!-- Fish Types Tab Content -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Fish Types List</h2>
        <button @click="openAddFishTypeModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center space-x-2">
            <x-heroicon-o-plus class="w-4 h-4" />
            <span>Add Fish Type</span>
        </button>
    </div>

    <!-- Add Fish Type Modal -->
    <div x-show="showAddFishTypeModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeAddFishTypeModal()"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Modal Header -->
                <div class="bg-white px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <x-heroicon-o-tag class="w-5 h-5 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Add New Fish Type</h3>
                                <p class="text-sm text-gray-500">Enter the details for the new fish type</p>
                            </div>
                        </div>
                        <button @click="closeAddFishTypeModal()"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                            <x-heroicon-o-x-mark class="w-6 h-6" />
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="bg-white px-6 py-6">
                    <form @submit.prevent="submitFishType()" class="space-y-6">
                        <!-- Fish Type Name -->
                        <div>
                            <label for="fishTypeName" class="block text-sm font-medium text-gray-700 mb-2">
                                Fish Type Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       id="fishTypeName"
                                       x-model="newFishType.name"
                                       placeholder="Enter fish type name (e.g., Tilapia, Catfish)"
                                       class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-tag class="h-5 w-5 text-gray-400" />
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="fishTypeDescription" class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea id="fishTypeDescription"
                                      x-model="newFishType.description"
                                      rows="4"
                                      placeholder="Enter a detailed description of the fish type..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                      required></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                    <button type="button"
                            @click="closeAddFishTypeModal()"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto transition-colors">
                        Cancel
                    </button>
                    <button type="button"
                            @click="submitFishType()"
                            class="w-full inline-flex justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-colors">
                        <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                        Add Fish Type
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                    <template x-for="product in products" :key="product.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <x-heroicon-o-tag class="w-5 h-5 text-white" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900" x-text="product.name"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900" x-text="product.description"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button @click="alert('Edit product functionality - implement server-side')"
                                            class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <x-heroicon-o-pencil-square class="w-6 h-6" />
                                    </button>
                                    <button @click="deleteProduct(product.id)"
                                            class="text-red-600 hover:text-red-900 transition-colors">
                                        <x-heroicon-o-trash class="w-6 h-6" />
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

<script>
function fishTypeManagement() {
    return {
        showAddFishTypeModal: false,
        newFishType: {
            name: '',
            description: ''
        },
        products: [
            {
                id: 1,
                name: 'Tilapia',
                description: 'Tilapia is a freshwater fish that is popular for its mild flavor and high protein content.'
            },
            {
                id: 2,
                name: 'Catfish',
                description: 'Catfish is a freshwater fish that is popular for its mild flavor and high protein content.'
            },
            {
                id: 3,
                name: 'Tilapia',
                description: 'Tilapia is a freshwater fish that is popular for its mild flavor and high protein content.'
            },
            {
                id: 4,
                name: 'Tilapia',
                description: 'Tilapia is a freshwater fish that is popular for its mild flavor and high protein content.'
            },
            {
                id: 5,
                name: 'Tilapia',
                description: 'Tilapia is a freshwater fish that is popular for its mild flavor and high protein content.'
            }
        ],
        categories: [
            { id: 1, name: 'Tilapia' },
            { id: 2, name: 'Catfish' },
            { id: 3, name: 'Tilapia' },
            { id: 4, name: 'Tilapia' }
        ],
        getCategoryName(categoryId) {
            const category = this.categories.find(cat => cat.id === categoryId);
            return category ? category.name : 'Unknown';
        },
        openAddFishTypeModal() {
            this.showAddFishTypeModal = true;
            this.newFishType = { name: '', description: '' };
        },
        closeAddFishTypeModal() {
            this.showAddFishTypeModal = false;
            this.newFishType = { name: '', description: '' };
        },
        submitFishType() {
            if (this.newFishType.name && this.newFishType.description) {
                // Add the new fish type to the products array
                const newId = Math.max(...this.products.map(p => p.id)) + 1;
                this.products.push({
                    id: newId,
                    name: this.newFishType.name,
                    description: this.newFishType.description
                });

                // Close modal and reset form
                this.closeAddFishTypeModal();

                // Show success message (you can replace this with a proper notification)
                alert('Fish type added successfully!');
            }
        },
        deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this fish type?')) {
                this.products = this.products.filter(p => p.id !== productId);
                alert('Fish type deleted successfully!');
            }
        }
    }
}
</script>
