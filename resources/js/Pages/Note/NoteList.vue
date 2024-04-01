<script setup>
import NoteItem from "@/Pages/Note/NoteItem.vue";
import NoteModal from "@/Pages/Note/NoteModal.vue";
import {computed, onMounted, ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import axiosClient from "@/AxiosClient.js";

const editNote = ref({});
const authUser = usePage().props.auth.user;
const loadMoreIntersect = ref(null);
const page = usePage();

const allNotes = ref({
    data: [],
    next: null
})

const props = defineProps({
    notes: Array,
    modelValue: Boolean
});

const emit = defineEmits(['update:modelValue'])

watch(() => page.props.notes, () => {
    if (page.props.notes) {
        allNotes.value = {
            data: page.props.notes.data,
            next: page.props.notes.links.next
        }
    }
}, {deep: true, immediate: true});

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => entries.forEach(entry => entry.isIntersecting && loadMore()), {
            rootMargin: '-250px 0px 0px 0px'
        })
    observer.observe(loadMoreIntersect.value)
})

function openEditModal(note) {
    editNote.value = note;
    show.value = true;
}

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
});

function onModalHide() {
    editNote.value = {
        id: null,
        title: '',
        content: '',
        user: authUser
    };
}

function loadMore() {
    if (!allNotes.value.next) {
        return;
    }
    axiosClient.get(allNotes.value.next)
        .then(({data}) => {
            allNotes.value.data = [...allNotes.value.data, ...data.data]
            allNotes.value.next = data.links.next
        })
}

</script>

<template>
    <table v-if="props.notes" class="w-full text-sm text-left rtl:text-right text-gray-500 p-4">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b-2 border-gray-500">
        <tr class="text-nowrap">
            <th class="p-3">ID</th>
            <th class="p-3">Название</th>
            <th class="p-3">Описание</th>
            <th class="p-3">Дата</th>
            <th class="p-3">Действия</th>
        </tr>
        </thead>
        <tbody>
            <NoteItem v-for="note of notes" :key="note.id" :note="note" @editClick="openEditModal"/>
        </tbody>
    </table>
    <div v-else class="p-6 text-center">У Вас пока нет заметок</div>

    <div ref="loadMoreIntersect" />

    <NoteModal @hide="onModalHide" :note="editNote" v-model="show" />
</template>

<style scoped>

</style>
