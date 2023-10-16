<script setup>
import { MenuItem } from '@headlessui/vue';
</script>

<template>
    <MenuItem v-slot="{ active }">
    <a class="text-gray-700 block px-4 py-2 text-sm">
        Upload Folder
    </a>
    </MenuItem>
</template>

