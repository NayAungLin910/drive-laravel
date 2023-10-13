<script setup>
import Modal from "@/Components/Modal.vue"
import InputLabel from "@/Components/InputLabel.vue"
import TextInput from "@/Components/TextInput.vue"
import InputError from "@/Components/InputError.vue"
import SecondaryButton from "@/Components/SecondaryButton.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue"
import { useForm, usePage } from "@inertiajs/vue3"
import { ref, nextTick } from "vue"

const props = defineProps({
    modelValue: Boolean,
})

const emit = defineEmits([
    'update:modelValue'
])

const form = useForm({
    name: '',
})

const folderNameInput = ref(null)

function createFolder() {

    form.post(route('folder.create'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()

            // success notification will be shown
        },
        onError: () => {
            folderNameInput.value.focus() // focus on the input
        }
    })
}

function closeModal() {
    emit('update:modelValue')
    form.clearErrors()
    form.reset()
}

function onShow() {
    nextTick(() => { folderNameInput.value.focus() })
}

</script>

<template>
    <Modal :show="props.modelValue" max-width="sm" @show="onShow">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create New Folder
            </h2>
            <div class="mt-6">
                <InputLabel for="folderName" value="Folder Name" />
                <TextInput ref="folderNameInput" type="text" id="folderName" v-model="form.name" class="mt-1 block w-full"
                    :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''"
                    placeholder="Folder Name" @keyup.enter="createFolder" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <PrimaryButton class="ml-3" @click="createFolder" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">Submit</PrimaryButton>
            </div>
        </div>
    </Modal>
</template>