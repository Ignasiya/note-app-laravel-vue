<script setup>
import {router, Link} from "@inertiajs/vue3";

const props = defineProps({
    note: {
        type: Object,
        default: null
    }
});

const emit = defineEmits(['editClick'])

function openEditModal() {
    emit('editClick', props.note);
}

function deleteNote() {
    if (window.confirm('Вы уверены что хотите удалить этот пост?')) {
        router.delete(route('note.destroy', props.note), {
            preserveScroll: true
        });
    }
}

</script>

<template>
    <tr class="border-b">
        <td class="px-3 py-2">{{ note.id }}</td>
        <td class="px-3 py-2">{{ note.title }}</td>
        <td class="px-3 py-2">{{ note.content }}</td>
        <td class="px-3 py-2">{{ note.updated_at }}</td>
        <td class="px-3 py-2">
            <button @click="openEditModal" class="font-medium text-sky-600 hover:underline mx-1">
                Изменить
            </button>
            <button @click="deleteNote" class="font-medium text-red-600 hover:underline mx-1">
                Удалить
            </button>
            <Link
                class="font-medium text-green-600 hover:underline mx-1"
                :href="route('note.view', note.id)"
                :class="[active ? 'bg-sky-600 text-white' : 'text-gray-600']"
            >
                Просмотреть
            </Link>
        </td>
    </tr>
</template>

<style scoped>

</style>
