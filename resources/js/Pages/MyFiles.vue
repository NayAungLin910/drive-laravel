<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { router, Link } from '@inertiajs/vue3'
import { HomeIcon } from '@heroicons/vue/20/solid'
import { ChevronRightIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    files: Object,
    folder: Object,
    ancestors: Object,
})

function openFolder(file) {
    if (!file.is_folder) {// if the file is not a folder
        return
    }

    router.visit(route('myFiles', { folder: file.path }))
}

</script>

<template>
    <AuthenticatedLayout>
        <nav class="flex items-center justify-between p-1 mb-3">
            <ol class="inline-flex items-center space-x-3 md:space-x-3">
                <li v-for="ans in ancestors.data" :key="ans.id" class="inline-flex items-center">

                    <!-- Root -->
                    <Link v-if="!ans.parent_id" :href="route('myFiles')" class="flex items-center text-sm
                    font-medium text-gray-700 hover:text-blue-600 dark:text-gray-500 dark:hover:text-gray-400">

                    <!-- Heroicons home icon -->
                    <HomeIcon class="h-6 w-6 mb-1 mr-1" />
                    <span>
                        MyFiles
                    </span>

                    </Link>

                    <div v-else class="flex items-center">

                        <Link :href="route('myFiles', { folder: ans.path })"
                            class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-500 dark:hover:text-gray-400">

                        <ChevronRightIcon class="h-6 w-6 inline-block" />
                        {{ ans.name }}

                        </Link>
                    </div>
                </li>
            </ol>
        </nav>
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

                <!-- Render the files inside the current directory -->
                <tr v-for="file in files.data" :key="file.id" @dblclick="openFolder(file)"
                    class="bg-white border-b transistion duration-300 ease-in-out hover:bg-gray-100 cursor-pointer">

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

        <!-- If no file is found -->
        <div v-if="!files.data.length" class="py-8 text-center text-base text-gray-500">
            There is no folder in the current directory!
        </div>
    </AuthenticatedLayout>
</template>