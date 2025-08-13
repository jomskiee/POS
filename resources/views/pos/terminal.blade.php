@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100" x-data="posTerminal()">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-4">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('employee.dashboard') }}" 
                   class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">POS Terminal</h1>
                    <p class="text-sm text-gray-500">Point of Sale System</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Current User -->
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                
                <!-- Current Time -->
                <div class="text-right border-l pl-4">
                    <p class="text-sm font-medium text-gray-900" x-text="currentTime"></p>
                    <p class="text-xs text-gray-500" x-text="currentDate"></p>
                </div>
            </div>
        </div>
    </header>

    <div class="flex h-screen pt-16">
        <!-- Left Panel - Products -->
        <div class="flex-1 p-6">
            <!-- Search and Categories -->
            <div class="mb-6">
                <div class="flex space-x-4 mb-4">
                    <!-- Search Bar -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input x-model="searchQuery" 
                                   type="text" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-lg"
                                   placeholder="Search products...">
                        </div>
                    </div>
                    
                    <!-- Barcode Scanner Button -->
                    <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5v5H4V4z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Categories -->
                <div class="flex space-x-2 overflow-x-auto pb-2">
                    <button @click="selectedCategory = 'all'" 
                            :class="selectedCategory === 'all' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 whitespace-nowrap transition-colors">
                        All Products
                    </button>
                    <button @click="selectedCategory = 'food'" 
                            :class="selectedCategory === 'food' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 whitespace-nowrap transition-colors">
                        Food & Drinks
                    </button>
                    <button @click="selectedCategory = 'electronics'" 
                            :class="selectedCategory === 'electronics' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 whitespace-nowrap transition-colors">
                        Electronics
                    </button>
                    <button @click="selectedCategory = 'clothing'" 
                            :class="selectedCategory === 'clothing' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 whitespace-nowrap transition-colors">
                        Clothing
                    </button>
                    <button @click="selectedCategory = 'accessories'" 
                            :class="selectedCategory === 'accessories' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 whitespace-nowrap transition-colors">
                        Accessories
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 overflow-y-auto max-h-[calc(100vh-300px)]">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div @click="addToCart(product)" 
                         class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md hover:border-blue-300 cursor-pointer transition-all group">
                        <div class="aspect-square bg-gray-100 rounded-lg mb-3 flex items-center justify-center group-hover:bg-gray-50 transition-colors">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-900 text-sm mb-1" x-text="product.name"></h3>
                        <p class="text-xs text-gray-500 mb-2" x-text="product.category"></p>
                        <p class="text-lg font-bold text-blue-600" x-text="'$' + product.price.toFixed(2)"></p>
                        <p class="text-xs text-gray-400" x-text="'Stock: ' + product.stock"></p>
                    </div>
                </template>
            </div>
        </div>

        <!-- Right Panel - Cart -->
        <div class="w-96 bg-white border-l border-gray-200 flex flex-col">
            <!-- Cart Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Current Order</h2>
                <div class="flex justify-between text-sm text-gray-500">
                    <span x-text="'Items: ' + cartItems.length"></span>
                    <span x-text="currentTime"></span>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6">
                <div x-show="cartItems.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13h10M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No items in cart</p>
                    <p class="text-xs text-gray-400">Select products to add them here</p>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, index) in cartItems" :key="index">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 text-sm" x-text="item.name"></h4>
                                <p class="text-xs text-gray-500" x-text="'$' + item.price.toFixed(2) + ' each'"></p>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <!-- Quantity Controls -->
                                <button @click="decreaseQuantity(index)" 
                                        class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                
                                <span class="w-8 text-center font-medium" x-text="item.quantity"></span>
                                
                                <button @click="increaseQuantity(index)" 
                                        class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                                
                                <!-- Remove Button -->
                                <button @click="removeFromCart(index)" 
                                        class="w-8 h-8 rounded-full bg-red-100 hover:bg-red-200 flex items-center justify-center text-red-600 ml-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Cart Footer -->
            <div class="border-t border-gray-200 p-6 space-y-4">
                <!-- Totals -->
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax (8%):</span>
                        <span x-text="'$' + tax.toFixed(2)"></span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                        <span>Total:</span>
                        <span x-text="'$' + total.toFixed(2)"></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2">
                    <button @click="clearCart()" 
                            :disabled="cartItems.length === 0"
                            :class="cartItems.length === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-700'"
                            class="w-full py-3 text-white rounded-lg font-medium transition-colors">
                        Clear Cart
                    </button>
                    
                    <button @click="processPayment()" 
                            :disabled="cartItems.length === 0"
                            :class="cartItems.length === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'"
                            class="w-full py-3 text-white rounded-lg font-medium transition-colors">
                        Process Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function posTerminal() {
    return {
        searchQuery: '',
        selectedCategory: 'all',
        cartItems: [],
        currentTime: '',
        currentDate: '',
        
        // Sample products data
        products: [
            { id: 1, name: 'Coca Cola', price: 2.50, category: 'food', stock: 50 },
            { id: 2, name: 'Sandwich', price: 8.99, category: 'food', stock: 25 },
            { id: 3, name: 'Coffee', price: 3.75, category: 'food', stock: 30 },
            { id: 4, name: 'iPhone 13', price: 699.99, category: 'electronics', stock: 5 },
            { id: 5, name: 'Samsung Galaxy', price: 599.99, category: 'electronics', stock: 8 },
            { id: 6, name: 'T-Shirt', price: 19.99, category: 'clothing', stock: 20 },
            { id: 7, name: 'Jeans', price: 49.99, category: 'clothing', stock: 15 },
            { id: 8, name: 'Watch', price: 129.99, category: 'accessories', stock: 10 },
            { id: 9, name: 'Sunglasses', price: 79.99, category: 'accessories', stock: 12 },
            { id: 10, name: 'Headphones', price: 199.99, category: 'electronics', stock: 7 },
            { id: 11, name: 'Water Bottle', price: 12.99, category: 'accessories', stock: 30 },
            { id: 12, name: 'Energy Drink', price: 3.25, category: 'food', stock: 40 },
        ],

        init() {
            this.updateTime();
            setInterval(() => this.updateTime(), 1000);
        },

        get filteredProducts() {
            let filtered = this.products;
            
            if (this.selectedCategory !== 'all') {
                filtered = filtered.filter(product => product.category === this.selectedCategory);
            }
            
            if (this.searchQuery) {
                filtered = filtered.filter(product => 
                    product.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
            
            return filtered;
        },

        get subtotal() {
            return this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },

        get tax() {
            return this.subtotal * 0.08;
        },

        get total() {
            return this.subtotal + this.tax;
        },

        updateTime() {
            const now = new Date();
            this.currentTime = now.toLocaleTimeString();
            this.currentDate = now.toLocaleDateString();
        },

        addToCart(product) {
            const existingItem = this.cartItems.find(item => item.id === product.id);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.cartItems.push({
                    ...product,
                    quantity: 1
                });
            }
        },

        removeFromCart(index) {
            this.cartItems.splice(index, 1);
        },

        increaseQuantity(index) {
            this.cartItems[index].quantity++;
        },

        decreaseQuantity(index) {
            if (this.cartItems[index].quantity > 1) {
                this.cartItems[index].quantity--;
            } else {
                this.removeFromCart(index);
            }
        },

        clearCart() {
            this.cartItems = [];
        },

        processPayment() {
            if (this.cartItems.length === 0) return;
            
            // Here you would typically integrate with payment processing
            alert(`Payment processed successfully!\nTotal: $${this.total.toFixed(2)}\nThank you for your purchase!`);
            this.clearCart();
        }
    }
}
</script>
@endsection