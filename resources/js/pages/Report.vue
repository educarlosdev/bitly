<script setup>
import Header from "../components/Header.vue";
import Divider from "../components/Divider.vue";
import StatsReport from "../components/StatsReport.vue";
import {EyeSlashIcon} from "@heroicons/vue/24/outline";
import Pagination from "../components/Pagination.vue";
import {onMounted} from "vue";
import {useHitStore} from "../store/hit";
import {useRoute} from "vue-router";
const hits = useHitStore();
const route = useRoute();
onMounted(() => {
    hits.pagination.current_page = 1;
    hits.search = '';
    if (route.params.id) {
        hits.showHit(route.params.id);
    } else {
        hits.indexHits();
    }
});
</script>

<template>
    <StatsReport />
    <Divider />
    <Header />
    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <ul v-if="hits.pagination.total > 0" role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <li v-for="item in hits.pagination.data" :key="item.id" class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                <div class="flex gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-600">
                                <span class="absolute inset-x-0 -top-px bottom-0" />
                            {{ item.parse_user_agent.platformFamily }}
                        </p>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            {{ item.ip }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-x-4">
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">
                            {{ item.parse_user_agent.browserFamily }}
                        </p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Clicado há <time :datetime="item.created_at">{{ item.created_formatted }}</time>
                        </p>
                    </div>
                </div>
            </li>
            <Pagination :pagination="hits.pagination" @paginate="hits.indexHits()" />
        </ul>
        <button v-else type="button" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center text-gray-400 cursor-default">
            <EyeSlashIcon class="h-12 w-12 mx-auto" aria-hidden="true"/>
            <span class="mt-2 block text-sm font-semibold text-gray-900">Nenhuma visualização registrada!</span>
        </button>
    </div>
</template>

<style scoped>

</style>
