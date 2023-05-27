<script setup>
import {HomeIcon, ChartBarIcon, TrashIcon, AdjustmentsVerticalIcon, ArrowsUpDownIcon, PlusIcon} from '@heroicons/vue/24/outline';
import {useLinkStore} from "../store/link";
const links = useLinkStore();
</script>

<template>
    <header class="">
        <nav class="mx-auto flex max-w-4xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex items-center gap-x-4">
                <router-link :to="{name: 'Dashboard'}">
                    <div
                        class="flex rounded p-1 font-extralight bg-gray-200 text-sky-400 hover:bg-white houver:text-sky-800">
                        <HomeIcon class="h-5 w-5 mr-2 mt-0.5" aria-hidden="true"/>
                        Home
                    </div>
                </router-link>
                <ChartBarIcon class="h-5 w-5 mr-2 text-gray-400" aria-hidden="true"/>
                <TrashIcon class="h-5 w-5 mr-2 text-gray-400" aria-hidden="true"/>
                <PlusIcon @click.prevent="links.addModalOpen()" class="h-5 w-5 mr-2 text-gray-400 cursor-pointer" aria-hidden="true"/>
            </div>
            <div class="flex items-center gap-x-4">
                <ArrowsUpDownIcon class="h-5 w-5 mr-2 text-gray-400" aria-hidden="true"/>
                <div
                    class="flex rounded p-1 bg-gray-200 text-gray-400 font-extralight">
                    <AdjustmentsVerticalIcon class="h-5 w-5 mr-2 mt-0.5" aria-hidden="true"/>
                    Filters
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>

</style>
