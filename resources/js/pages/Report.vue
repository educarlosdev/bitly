<script setup>
import Header from "../components/Header.vue";
import Divider from "../components/Divider.vue";
import StatsReport from "../components/StatsReport.vue";
import {EyeSlashIcon} from "@heroicons/vue/24/outline";
import Pagination from "../components/Pagination.vue";
</script>

<template>
    <StatsReport />
    <Divider />
    <Header />
    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <ul v-if="0 > 0" role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <li v-for="item in 4" :key="item" class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                <div class="flex gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                                <span class="absolute inset-x-0 -top-px bottom-0" />
                                Dispositivo
                        </p>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            IP
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-x-4">
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">Navegador</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Clicado em <time datetime="2023-01-23T13:23Z">2023-01-23T13:23Z</time>
                        </p>
                    </div>
                </div>
            </li>
<!--            <Pagination :pagination="links.pagination" v-if="links.pagination.total > links.pagination.per_page" @paginate="links.indexLinks()" />-->
        </ul>
        <button v-else type="button" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center text-gray-400 cursor-default">
            <EyeSlashIcon class="h-12 w-12 mx-auto" aria-hidden="true"/>
            <span class="mt-2 block text-sm font-semibold text-gray-900">Nenhuma visualização registrada!</span>
        </button>
    </div>
</template>

<style scoped>

</style>
