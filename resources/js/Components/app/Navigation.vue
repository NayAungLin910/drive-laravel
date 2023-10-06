<script setup>
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import CreateNewDropdown from './CreateNewDropdown.vue'
import NavLink from '@/Components/NavLink.vue';

</script>

<template>
    <nav class="min-w-[200px]">

        <Link :href="route('myFiles')" class="h-[80px] px-3 flex items-center gap-3">
        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
        LaraDrive
        </Link>

        <div class="px-3">
            <CreateNewDropdown />

            <div class="py-3">

                <!-- active for routes that start with /my-files -->
                <NavLink :href="route('myFiles')" :active="/^\/my-files/.test($page.url)">
                    My Files
                </NavLink>
                <NavLink href="/">
                    Shared with me
                </NavLink>
                <NavLink href="/">
                    Shared by me
                </NavLink>
                <NavLink href="/">
                    Trash
                </NavLink>
            </div>
        </div>
    </nav>
</template>

<style scoped></style>