<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue'; // Tambahan computed import

const props = defineProps({
    item: Object
});

// Tambahan untuk error notification
const errorMessage = ref('');
const showError = ref(false);

const form = useForm({
    qty: 0,
    note: '',
    description: ''
});

// Computed untuk validasi realtime
const isStockSufficient = computed(() => {
    if (form.note === 'out' && form.qty > 0) {
        return props.item.qty >= form.qty;
    }
    return true;
});

const stockWarningMessage = computed(() => {
    if (form.note === 'out' && form.qty > 0 && !isStockSufficient.value) {
        return `Stok tidak mencukupi! Stok tersedia: ${props.item.qty} ${props.item.unit}, diminta: ${form.qty} ${props.item.unit}`;
    }
    return '';
});

const submitForm = () => {
    // Reset error state sebelum submit
    showError.value = false;
    errorMessage.value = '';

    // Validasi client-side untuk stock out
    if (form.note === 'out' && form.qty > props.item.qty) {
        errorMessage.value = `Stok tidak mencukupi! Stok tersedia: ${props.item.qty} ${props.item.unit}, diminta: ${form.qty} ${props.item.unit}`;
        showError.value = true;
        
        // Auto hide error setelah 5 detik
        setTimeout(() => {
            showError.value = false;
        }, 5000);
        return;
    }

    form.patch(`/items/${props.item.id}/update-stock`, {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
            // Tambahan untuk menampilkan error
            if (errors.qty) {
                errorMessage.value = errors.qty;
            } else if (errors.note) {
                errorMessage.value = errors.note;
            } else if (errors.name) {
                errorMessage.value = errors.name;
            } else if (errors.unit) {
                errorMessage.value = errors.unit;
            } else {
                errorMessage.value = 'Terjadi kesalahan saat menyimpan data';
            }
            showError.value = true;
            
            // Auto hide error setelah 5 detik
            setTimeout(() => {
                showError.value = false;
            }, 5000);
        }
    });
};
</script>

<template>
    <Head title="Edit Stock Changes Item" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Stock Changes Item : {{ props.item.name }} ({{ props.item.qty }} {{ props.item.unit }})
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Error Notification -->
                        <div v-if="showError" class="mb-4 p-4 border-l-4 border-red-500 bg-red-50 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-800">{{ errorMessage }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <button @click="showError = false" type="button" class="text-red-400 hover:text-red-600">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Real-time Stock Warning -->
                        <div v-if="stockWarningMessage" class="mb-4 p-4 border-l-4 border-yellow-500 bg-yellow-50 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-800">{{ stockWarningMessage }}</p>
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Quantity Field -->
                            <div>
                                <label for="qty" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input 
                                    type="number" 
                                    v-model="form.qty" 
                                    id="qty" 
                                    required 
                                    min="1"
                                    :class="[
                                        'mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                        !isStockSufficient ? 'border-red-300 bg-red-50' : ''
                                    ]"
                                >
                                <p v-if="form.errors.qty" class="mt-2 text-sm text-red-600">{{ form.errors.qty }}</p>
                            </div>

                            <!-- Transaction Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transaction Type</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            id="note-in" 
                                            v-model="form.note" 
                                            name="note" 
                                            value="in" 
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                        >
                                        <label for="note-in" class="ml-3 block text-sm font-medium text-gray-700">
                                            Stock IN
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                Add
                                            </span>
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            id="note-out" 
                                            v-model="form.note" 
                                            name="note" 
                                            value="out" 
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                        >
                                        <label for="note-out" class="ml-3 block text-sm font-medium text-gray-700">
                                            Stock OUT
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Remove
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <p v-if="form.errors.note" class="mt-2 text-sm text-red-600">{{ form.errors.note }}</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea 
                                    id="description" 
                                    v-model="form.description" 
                                    rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Enter description for this stock transaction..."
                                ></textarea>
                                <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-end space-x-4">
                                <button 
                                    type="button" 
                                    @click="$inertia.visit('/items')"
                                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </button>
                                <PrimaryButton 
                                    type="submit" 
                                    :disabled="form.processing || !isStockSufficient"
                                    :class="[
                                        'ml-4',
                                        !isStockSufficient ? 'opacity-50 cursor-not-allowed' : ''
                                    ]"
                                >
                                    <span v-if="form.processing" class="inline-flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Updating...
                                    </span>
                                    <span v-else>Update Stock</span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>