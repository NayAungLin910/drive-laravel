<script setup>
import { MenuItem } from '@headlessui/vue'
import { emitter, FILE_UPLOAD_STARTED } from "@/event-bus"

// fire FILE_UPLOAD_STARTED event witht the files uploaded
function onChange(event) {
    emitter.emit(FILE_UPLOAD_STARTED, event.target.files)
}

</script>

<template>
    <MenuItem v-slot="{ active }">
    <a class="text-gray-700 block px-4 py-2 text-sm relative">
        Upload Files

        <input @change="onChange" type="file" multiple class="absolute left-0 bottom-0 right-0 cursor-pointer opacity-0">
    </a>
    </MenuItem>
</template>
