<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    items: Array
});
</script>

<template>
    <Head title="Items" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Items List
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">

                        <PrimaryButton>
                            <a href="/items/create" class="text-white no-underline">
                                Add Item
                            </a>
                        </PrimaryButton>

                        <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-black-700 px-4 py-3 m-2 rounded relative" role="alert">
                            {{ $page.props.flash.success }}
                        </div>

                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Quantity</th>
                                    <th class="px-4 py-2">Unit</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in items" :key="index">
                                    <td class="border px-4 py-2">{{ ++index }}</td>
                                    <td class="border px-4 py-2">{{ item.name }}</td>
                                    <td class="border px-4 py-2">{{ item.qty }}</td>
                                    <td class="border px-4 py-2">{{ item.unit }}</td>
                                    <td class="border px-4 py-2">
                                        <button @click="$emit('edit', item)" class="text-blue-500 hover:underline">Edit</button>
                                        <button @click="$emit('delete', item)" class="text-red-500 hover:underline ml-2">Delete</button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>