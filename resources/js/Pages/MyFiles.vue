<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    files: Object,
})

</script>

<template>
    <AuthenticatedLayout>
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Name
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Owner
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Last Modified
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Size
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="file in files.data" :key="file.id"
                    class="bg-white border-b transistion duration-300 ease-in-out hover:bg-gray-100">

                    <!-- File Name -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray">
                        {{ file.name }}
                    </td>

                    <!-- Owned By -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray">
                        {{ file.owner }}
                    </td>

                    <!-- Last Updated At -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray">
                        {{ file.updated_at }}
                    </td>

                    <!-- Size -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray">
                        {{ file.size }}
                    </td>
                </tr>
            </tbody>
        </table>
    </AuthenticatedLayout>
</template>