<script setup>

const props = defineProps(['pagination']);
const emit = defineEmits(['paginate']);

const change = (previousOrNext) => {
    if(previousOrNext < 1) return;
    if(previousOrNext > props.pagination.last_page) return;
    props.pagination.current_page = previousOrNext;
    emit('paginate');
};
</script>

<template>
    <nav class="flex items-center justify-between shadow rounded bg-white px-4 py-3 sm:px-6" aria-label="Pagination" v-if="pagination.total > pagination.per_page">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Mostrando
                {{ ' ' }}
                <span class="font-medium">{{ pagination.from
                    }}</span>
                {{ ' ' }}
                até
                {{ ' ' }}
                <span class="font-medium">{{ pagination.to }}</span>
                {{ ' ' }}
                de
                {{ ' ' }}
                <span class="font-medium">{{ pagination.total }}</span>
                {{ ' ' }}
                resultados
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end">
            <button type="button" @click.prevent="change(pagination.current_page - 1)" class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:text-sky-500 focus-visible:outline-offset-0 disabled:hover:text-gray-900 disabled:bg-gray-200" :disabled="pagination.current_page === 1">Anterior</button>
            <button type="button" @click.prevent="change(pagination.current_page + 1)" class="relative ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:text-sky-500 focus-visible:outline-offset-0 disabled:hover:text-gray-900 disabled:bg-gray-200" :disabled="pagination.current_page === props.pagination.last_page">Próximo</button>
        </div>
    </nav>
</template>

<style scoped>

</style>
