<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'; // Tambahan import

// Tambahan untuk error notification
const errorMessage = ref('');
const showError = ref(false);

const form = useForm({
    name: '',
    qty: 0,
    unit: ''
});

const submitForm = () => {
    // Reset error state sebelum submit
    showError.value = false;
    errorMessage.value = '';
    
    form.post('/items', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
            // Tambahan untuk menampilkan error
            if (errors.name) {
                errorMessage.value = errors.name;
            } else if (errors.qty) {
                errorMessage.value = errors.qty;
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
    <Head title="Add Item" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Add New Item
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">

                        <!-- Error Notification -->
                        <div v-if="showError" class="mb-4 p-4 border-l-4 border-red-500 bg-gradient-to-r from-red-50 to-red-100 rounded-lg shadow-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-red-800">{{ errorMessage }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <button @click="showError = false" type="button" class="inline-flex text-red-500 hover:text-red-700 hover:bg-red-200 rounded-full p-1 transition-colors duration-200">
                                        <span class="sr-only">Dismiss</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div class="mt-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Item Name</label>
                                <input type="text" v-model="form.name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <!-- Error message untuk field name -->
                                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.name }}</p>
                            </div>

                            <div class="mt-4">
                                <label for="qty" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" v-model="form.qty" id="qty" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <!-- Error message untuk field qty -->
                                <p v-if="form.errors.qty" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.qty }}</p>
                            </div>

                            <div class="mt-4">
                                <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                                <input type="text" v-model="form.unit" id="unit" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <!-- Error message untuk field unit -->
                                <p v-if="form.errors.unit" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.unit }}</p>
                            </div>

                            <div class="mt-6">
                                <PrimaryButton type="submit">Add Item</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>