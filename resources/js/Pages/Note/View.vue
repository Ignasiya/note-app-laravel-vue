<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

defineProps({
    note: Object
})

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Заметка"/>

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Заметка</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="px-3 py-2 text-center font-semibold">{{ note.data.title }}</h3>
                    <p class="px-3 py-2 text-center">{{ note.data.content }}</p>
                    <small class="px-3 py-2">{{ note.data.updated_at }}</small>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
