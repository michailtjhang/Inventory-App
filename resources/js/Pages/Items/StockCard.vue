<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import dayjs from 'dayjs';

const props = defineProps({
    item: Object
});
</script>

<template>
    <Head title="Stock Card" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Stock Card for {{ item.name }} - {{ item.qty }} {{ item.unit }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Quantity</th>
                                    <th class="px-4 py-2">Note</th>
                                    <th class="px-4 py-2">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in item.stock_cards" :key="index">
                                    <td class="border px-4 py-2">{{ ++index }}</td>
                                    <td class="border px-4 py-2">{{ dayjs(item.created_at).format('DD/MM/YYYY HH:mm:ss') }}</td>
                                    <td class="border px-4 py-2">{{ item.qty }}</td>
                                    <td class="border px-4 py-2">{{ item.note }}</td>
                                    <td class="border px-4 py-2">{{ item.description }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>