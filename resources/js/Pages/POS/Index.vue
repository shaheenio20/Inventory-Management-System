<template>
  <AdminLayout header="POS Terminal">
    <div class="h-[calc(100vh-64px)] flex flex-col md:flex-row bg-gray-100 dark:bg-gray-900 overflow-hidden">
      
      <!-- Left Side: Products Grid -->
      <div class="w-full md:w-2/3 flex flex-col h-full border-r border-gray-200 dark:border-gray-700">
        
        <!-- Search & Filter Bar -->
        <div class="p-4 bg-white dark:bg-gray-800 shadow-sm z-10 flex gap-2">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input 
                    type="text" 
                    v-model="searchQuery" 
                    @keyup.enter="handleBarcodeScan"
                    ref="searchInput"
                    placeholder="Search by name or scan barcode..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                />
            </div>
            <select v-model="selectedCategory" class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 dark:text-white focus:ring-blue-500">
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>

        <!-- Products Area -->
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
            <div v-if="filteredProducts.length === 0" class="text-center py-10 text-gray-500 dark:text-gray-400">
                No products found.
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <div 
                    v-for="product in filteredProducts" 
                    :key="product.id" 
                    @click="addToCart(product)"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 cursor-pointer transition transform hover:-translate-y-1 overflow-hidden flex flex-col h-40"
                >
                    <div class="p-3 flex-1 flex flex-col justify-center items-center text-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-box text-xl"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-100 line-clamp-2 leading-tight" :title="product.name">
                            {{ product.name }}
                        </h3>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-3 py-2 flex justify-between items-center border-t border-gray-100 dark:border-gray-700">
                        <span class="text-blue-600 dark:text-blue-400 font-bold">${{ parseFloat(product.price).toFixed(2) }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Stock: {{ product.stock_quantity }}</span>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <!-- Right Side: Cart & Checkout -->
      <div class="w-full md:w-1/3 flex flex-col h-full bg-white dark:bg-gray-800 shadow-lg z-20">
        
        <!-- Customer Info -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-3">Current Sale</h2>
            <div class="flex gap-2 mb-2">
                <div class="relative flex-1">
                    <i class="fas fa-user absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                    <input type="text" v-model="form.customer_name" placeholder="Customer Name (Optional)" class="w-full pl-8 pr-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 dark:text-white focus:ring-blue-500">
                </div>
                <div class="relative flex-1">
                    <i class="fas fa-phone absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                    <input type="text" v-model="form.customer_phone" placeholder="Phone (Optional)" class="w-full pl-8 pr-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 dark:text-white focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
            <div v-if="cart.length === 0" class="flex flex-col items-center justify-center h-full text-gray-400">
                <i class="fas fa-shopping-cart text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                <p>Cart is empty</p>
                <p class="text-xs mt-1">Scan a barcode or click a product</p>
            </div>
            
            <div v-else class="space-y-3">
                <div v-for="(item, index) in cart" :key="index" class="flex justify-between items-center bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <div class="flex-1 min-w-0 pr-2">
                        <p class="text-sm font-bold text-gray-800 dark:text-white truncate" :title="item.name">{{ item.name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${{ parseFloat(item.unit_price).toFixed(2) }}</p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 overflow-hidden">
                            <button @click="updateQuantity(index, -1)" class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <input type="number" v-model.number="item.quantity" class="w-10 text-center text-sm border-none focus:ring-0 p-0 bg-transparent dark:text-white" min="1" @change="validateQuantity(index)">
                            <button @click="updateQuantity(index, 1)" class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                        
                        <div class="w-16 text-right font-bold text-gray-800 dark:text-white text-sm">
                            ${{ (item.quantity * item.unit_price).toFixed(2) }}
                        </div>
                        
                        <button @click="removeFromCart(index)" class="text-red-500 hover:text-red-700 p-1 ml-1 transition">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Section -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-2 text-gray-600 dark:text-gray-400">
                <span>Subtotal</span>
                <span>${{ cartTotal.toFixed(2) }}</span>
            </div>
            <div class="flex justify-between items-center mb-4 text-xl font-black text-gray-900 dark:text-white">
                <span>Total</span>
                <span>${{ cartTotal.toFixed(2) }}</span>
            </div>
            
            <!-- Payment Method Selection -->
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-2">Payment Method</label>
                <div class="flex gap-2">
                    <button @click="paymentMethod = 'cash'" :class="paymentMethod === 'cash' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600'" class="flex-1 py-2 rounded-lg border font-bold transition text-sm">
                        <i class="fas fa-money-bill-wave mr-1"></i> Cash
                    </button>
                    <button @click="setPaymentMethod('card')" :class="paymentMethod === 'card' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600'" class="flex-1 py-2 rounded-lg border font-bold transition text-sm">
                        <i class="fas fa-credit-card mr-1"></i> Card
                    </button>
                    <button @click="paymentMethod = 'bank'" :class="paymentMethod === 'bank' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600'" class="flex-1 py-2 rounded-lg border font-bold transition text-sm">
                        <i class="fas fa-university mr-1"></i> Bank
                    </button>
                </div>
            </div>

            <!-- Cash Payment Options -->
            <template v-if="paymentMethod === 'cash'">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Amount Tendered</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500 font-bold">$</span>
                        <input type="number" v-model.number="amountTendered" class="w-full pl-7 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-900 dark:text-white font-bold text-lg focus:ring-green-500 focus:border-green-500" placeholder="0.00">
                    </div>
                </div>
                
                <div class="flex justify-between items-center mb-4 p-3 bg-gray-100 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Change Due</span>
                    <span class="font-black text-lg" :class="changeDue >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-500'">
                        ${{ changeDue >= 0 ? changeDue.toFixed(2) : '0.00' }}
                    </span>
                </div>
            </template>

            <!-- Bank Payment Options -->
            <template v-if="paymentMethod === 'bank'">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Account / Reference Number</label>
                    <div class="relative">
                        <i class="fas fa-hashtag absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" v-model="form.payment_reference" class="w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 dark:text-white focus:ring-blue-500" placeholder="e.g. TRN-987654321">
                    </div>
                </div>
            </template>

            <!-- Stripe Card Element -->
            <div v-show="paymentMethod === 'card'" class="mb-4">
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Card Details</label>
                <div v-if="!stripeKey" class="p-3 border border-yellow-300 bg-yellow-50 text-yellow-800 rounded-lg text-sm">
                    <strong>Demo Mode Active:</strong> Stripe keys are missing in your .env file. Card payments will be simulated.
                </div>
                <div v-else id="card-element" class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <div id="card-errors" class="text-red-500 text-xs mt-1 font-bold"></div>
            </div>

            <button 
                @click="checkout" 
                :disabled="cart.length === 0 || form.processing || isProcessingStripe"
                class="w-full py-4 rounded-xl font-black text-lg text-white shadow-lg transition transform active:scale-95 flex justify-center items-center gap-2"
                :class="cart.length === 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'"
            >
                <i v-if="form.processing || isProcessingStripe" class="fas fa-spinner fa-spin"></i>
                <i v-else class="fas fa-check-circle"></i>
                {{ form.processing || isProcessingStripe ? 'Processing...' : (paymentMethod === 'card' ? 'Pay with Card' : 'Checkout') }}
            </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import Swal from 'sweetalert2';
import { loadStripe } from '@stripe/stripe-js';

const props = defineProps({
    products: Array,
    categories: Array,
    stripeKey: String
});

const searchQuery = ref('');
const selectedCategory = ref('');
const searchInput = ref(null);
const cart = ref([]);
const amountTendered = ref('');
const paymentMethod = ref('cash');
const isProcessingStripe = ref(false);

let stripe = null;
let cardElement = null;

const form = useForm({
    customer_name: '',
    customer_phone: '',
    sale_date: new Date().toISOString().split('T')[0],
    products: [],
    payment_method: 'cash',
    stripe_transaction_id: null,
    payment_reference: ''
});

onMounted(() => {
    // Focus search bar on load for immediate barcode scanning
    if (searchInput.value) {
        searchInput.value.focus();
    }
});

// Filtering logic
const filteredProducts = computed(() => {
    return props.products.filter(product => {
        const matchesSearch = product.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
                              (product.barcode && product.barcode === searchQuery.value);
        const matchesCategory = selectedCategory.value === '' || product.category_id === selectedCategory.value;
        return matchesSearch && matchesCategory;
    });
});

const cartTotal = computed(() => {
    return cart.value.reduce((total, item) => total + (item.quantity * item.unit_price), 0);
});

const changeDue = computed(() => {
    const tendered = parseFloat(amountTendered.value) || 0;
    return tendered - cartTotal.value;
});

const handleBarcodeScan = () => {
    if (!searchQuery.value) return;
    
    // Find exact match (assuming exact match on name or hypothetical barcode field)
    const exactMatch = props.products.find(p => p.name.toLowerCase() === searchQuery.value.toLowerCase());
    
    if (exactMatch) {
        addToCart(exactMatch);
        searchQuery.value = ''; // clear for next scan
    } else if (filteredProducts.value.length === 1) {
        // If only one product remains from filter, add it
        addToCart(filteredProducts.value[0]);
        searchQuery.value = '';
    }
};

const addToCart = (product) => {
    const existingIndex = cart.value.findIndex(item => item.product_id === product.id);
    
    if (existingIndex !== -1) {
        // Check stock limit
        if (cart.value[existingIndex].quantity < product.stock_quantity) {
            cart.value[existingIndex].quantity++;
        } else {
            Swal.fire('Stock Limit', 'Cannot add more of this item.', 'warning');
        }
    } else {
        cart.value.push({
            product_id: product.id,
            name: product.name,
            quantity: 1,
            unit_price: product.price,
            max_stock: product.stock_quantity
        });
    }
};

const updateQuantity = (index, delta) => {
    const newQty = cart.value[index].quantity + delta;
    if (newQty > 0 && newQty <= cart.value[index].max_stock) {
        cart.value[index].quantity = newQty;
    }
};

const validateQuantity = (index) => {
    const item = cart.value[index];
    if (item.quantity < 1) item.quantity = 1;
    if (item.quantity > item.max_stock) {
        item.quantity = item.max_stock;
        Swal.fire('Stock Limit', `Only ${item.max_stock} available.`, 'warning');
    }
};

const removeFromCart = (index) => {
    cart.value.splice(index, 1);
};

const setPaymentMethod = async (method) => {
    paymentMethod.value = method;
    if (method === 'card') {
        if (!props.stripeKey) {
            // Enter Mock Mode
            return;
        }
        await nextTick();
        if (!stripe) {
            stripe = await loadStripe(props.stripeKey);
            const elements = stripe.elements();
            cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#32325d',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        '::placeholder': {
                            color: '#aab7c4',
                        },
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a',
                    },
                }
            });
            cardElement.mount('#card-element');
            cardElement.on('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        }
    }
};

const checkout = async () => {
    if (cart.value.length === 0) return;
    
    if (paymentMethod.value === 'cash' && amountTendered.value && changeDue.value < 0) {
        Swal.fire('Insufficient Funds', 'Amount tendered is less than the total.', 'error');
        return;
    }

    form.products = cart.value.map(item => ({
        product_id: item.product_id,
        quantity: item.quantity,
        unit_price: item.unit_price
    }));
    
    form.payment_method = paymentMethod.value;
    form.stripe_transaction_id = null;

    if (paymentMethod.value === 'card') {
        isProcessingStripe.value = true;
        
        try {
            // 1. Get client secret from backend
            const res = await axios.post('/pos/payment-intent', { amount: cartTotal.value });
            
            if (res.data.mock_mode) {
                // Simulate a fast payment
                await new Promise(r => setTimeout(r, 1000));
                form.stripe_transaction_id = 'mock_txn_' + Math.floor(Math.random() * 1000000);
            } else {
                // 2. Confirm card payment with Stripe
                const { paymentIntent, error } = await stripe.confirmCardPayment(res.data.clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: form.customer_name || 'Walk-in Customer'
                        }
                    }
                });
                
                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    isProcessingStripe.value = false;
                    return;
                }
                
                // Success
                form.stripe_transaction_id = paymentIntent.id;
            }
            
        } catch (err) {
            Swal.fire('Payment Error', err.response?.data?.error || err.message, 'error');
            isProcessingStripe.value = false;
            return;
        }
    }

    // Process the final form submission to create the Sale
    form.post('/sales', {
        onSuccess: () => {
            cart.value = [];
            amountTendered.value = '';
            form.customer_name = '';
            form.customer_phone = '';
            form.payment_reference = '';
            paymentMethod.value = 'cash';
            isProcessingStripe.value = false;
            if (cardElement) cardElement.clear();
        },
        onError: () => {
            isProcessingStripe.value = false;
        }
    });
};
</script>

<style scoped>
/* Optional custom scrollbar hiding for main view to keep it app-like */
</style>
