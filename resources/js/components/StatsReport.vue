<script setup>
import {LinkIcon, EyeIcon} from '@heroicons/vue/24/outline';
import {useDashboardStore} from "../store/dashboard";
import {onMounted} from "vue";

const dashboard = useDashboardStore();

onMounted(() => {
    dashboard.showMetrics();
});
</script>

<template>
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 pt-10 pb-4">
        <div class="flex justify-between">
            <h3 class="text-base leading-7 text-gray-400 font-bold uppercase">Métricas</h3>
        </div>
        <dl class="mt-5 grid grid-cols-1 gap-2 sm:grid-cols-5">
            <div class="overflow-hidden rounded-lg px-4 py-5 shadow sm:p-6">
                <div class="flex justify-between">
                    <EyeIcon class="h-6 w-6 text-gray-400" aria-hidden="true"/>
                    <div>
                        <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">{{ dashboard.metrics.links }}</dd>
                        <dt class="truncate text-sm font-light text-gray-400">Views</dt>
                    </div>
                </div>
            </div>
        </dl>
    </div>
</template>

<style scoped>

</style>
