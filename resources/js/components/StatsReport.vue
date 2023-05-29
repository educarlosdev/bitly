<script setup>
import {useDashboardStore} from "../store/dashboard";
import {onMounted} from "vue";
import {useHitStore} from "../store/hit";
import {useRoute} from "vue-router";

const dashboard = useDashboardStore();
const hits = useHitStore();
const route = useRoute();

onMounted(() => {
    dashboard.showMetrics();
});

const doExportHits = () => {
    hits.export = true;
    if (route.params.id) {
        hits.showHit(route.params.id);
    } else {
        hits.indexHits();
    }
}
</script>

<template>
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 pt-10 pb-4">
        <div class="flex justify-between">
            <h3 class="text-base leading-7 text-gray-400 font-bold uppercase">Relatório</h3>
            <button @click.prevent="doExportHits()" type="button" class="inline-flex items-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">Exportar</button>
        </div>
    </div>
</template>

<style scoped>

</style>
