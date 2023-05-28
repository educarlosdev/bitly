<script setup>
import {HomeIcon, ChartBarIcon, TrashIcon, MagnifyingGlassIcon, ArrowsUpDownIcon, PlusIcon} from '@heroicons/vue/24/outline';
import {useLinkStore} from "../store/link";
import {useAuthStore} from "../store/auth";
const links = useLinkStore();
const auth = useAuthStore();

const searchFocus = () => {
    document.getElementById('search').focus();
}
</script>

<template>
    <header class="h-16">
        <nav class="mx-auto flex max-w-4xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex items-center gap-x-4">
                <router-link :to="{name: 'Dashboard'}">
                    <HomeIcon class="h-5 w-5 mr-2 text-gray-400 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-400" aria-hidden="true"/>
                </router-link>
                <router-link :to="{name: 'Report'}">
                    <ChartBarIcon  class="h-5 w-5 mr-2 text-gray-400 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-400" aria-hidden="true"/>
                </router-link>
                <TrashIcon @click.prevent="links.destroyLinksAll()" v-if="$route.name === 'Dashboard'" class="h-5 w-5 mr-2 text-gray-400 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-400" aria-hidden="true"/>
                <PlusIcon @click.prevent="links.addModalOpen()" v-if="$route.name === 'Dashboard'" class="h-5 w-5 mr-2 text-gray-400 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-400" aria-hidden="true"/>
            </div>
            <div class="flex items-center gap-x-4">
                <ArrowsUpDownIcon @click.prevent="links.linkOrderModalOpen = true" v-if="$route.name === 'Dashboard'" class="h-5 w-5 mr-2 text-gray-400 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-400" aria-hidden="true"/>
                <MagnifyingGlassIcon @click.prevent="searchFocus()" v-if="$route.name === 'Dashboard'" class="h-5 w-5 text-gray-400 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-400" aria-hidden="true"/>
            </div>
        </nav>
    </header>
</template>

<style scoped>

</style>
