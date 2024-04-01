<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import {computed, watch} from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextareaInput from "@/Components/TextareaInput.vue";

const authUser = usePage().props.auth.user;

const props = defineProps({
    note: {
        type: Object,
        required: true
    },
    modelValue: Boolean
});

const form = useForm({
    id: null,
    title: '',
    content: '',
    user_id: authUser.id,
    _method: 'POST'
});

const emit = defineEmits(['update:modelValue', 'hide'])

watch(() => props.note, () => {
    form.title = props.note.title || '';
    form.content = props.note.content || '';
})

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
});

function closeModal() {
    show.value = false;
    emit('hide');
    form.reset();
}

function submit() {
    if (props.note.id) {
        form._method = 'PUT';
        form.post(route('note.update', props.note.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            }
        });
    } else {
        form.post(route('note.create'), {
            preserveScroll: true,
            onSuccess: () => {
                show.value = false
                closeModal();
            },
        });
    }
}

</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="px-4 py-3">
            <div class="mb-3">
                <label class="text-gray-700">
                    Название заметки
                </label>
                <TextInput
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                />
            </div>

            <div class="mb-3">
                <label class="text-gray-700">
                    Содержание заметки
                </label>
                <TextareaInput
                    v-model="form.content"
                    class="w-full max-h-[150px] rounded-[7px] resize-none"
                    required
                />
            </div>

            <div class="flex justify-end">
                <SecondaryButton @click="closeModal"> Отмена </SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="submit"
                >
                    Сохранить
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<style scoped>

</style>
