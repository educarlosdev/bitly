<script setup>
import {onMounted} from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {
    ArrowTrendingUpIcon,
    TrashIcon,
    EllipsisVerticalIcon,
    PencilIcon,
    LinkIcon,
    DocumentDuplicateIcon
} from '@heroicons/vue/24/outline';
import Header from "../components/Header.vue";
import Divider from "../components/Divider.vue";
import StatsDashboard from "../components/StatsDashboard.vue";
import {useLinkStore} from "../store/link";
import Swal from "sweetalert2";
import Pagination from "../components/Pagination.vue";
import {useAuthStore} from "../store/auth";

const auth = useAuthStore();
const links = useLinkStore();

const copy = (payload) => {
    navigator.clipboard.writeText(payload);
    Swal.fire({
        icon: 'success',
        title: 'Link copiado com sucesso para área de transferência!',
        showConfirmButton: false,
        timer: 600
    });
}

onMounted(() => {
    links.indexLinks();
});
</script>

<template>
    <StatsDashboard/>
    <Divider/>
    <Header/>
    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <ul role="list" v-if="links.pagination.total > 0" class="pb-16">
            <li v-for="link in links.pagination.data" :key="link.id"
                class="relative flex justify-between gap-x-3 py-8 bg-white rounded-md mb-4">
                <div class="flex items-center">
                    <EllipsisVerticalIcon class="h-8 w-8 text-gray-200 mr-4" aria-hidden="true"/>
                    <div>
                        <p class="text-lg font-semibold leading-6 text-gray-900">
                            <a @click="link.views++" :href="link.slug_url" target="_blank" class="hover:underline">{{ link.slug_url }}</a>
                        </p>
                        <div class="mt-1 flex items-center gap-x-2 text-xs font-semibold leading-5 text-sky-400">
                            <p>
                                <a :href="link.url" target="_blank" class="hover:underline">{{ link.url }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <dl class="flex items-center justify-between gap-x-8">
                    <div class="hidden md:flex gap-x-2 pr-5">
                        <span class="text-gray-300 text-xs mr-0 mt-1">{{ link.views }}</span>
                        <router-link :to="{name: 'ReportWithId', params: {id: link.id}}" class="flex items-center justify-between gap-x-2">
                            <ArrowTrendingUpIcon class="h-4 w-4 text-gray-300 mr-3 ml-0 mt-1 hover:h-5 hover:w-5 hover:text-sky-500" aria-hidden="true"/>
                        </router-link>
                        <DocumentDuplicateIcon @click.prevent="copy(link.slug_url)" class="h-5 w-5 text-gray-500 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-500" aria-hidden="true"/>
                        <PencilIcon @click.prevent="links.editModalOpen(link)" class="h-5 w-5 text-gray-500 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-500" aria-hidden="true"/>
                        <TrashIcon @click.prevent="links.destroyLink(link)" class="h-5 w-5 text-gray-500 cursor-pointer hover:h-6 hover:w-6 hover:text-sky-500" aria-hidden="true"/>
                    </div>
                    <div class="md:hidden flex gap-x-2 pr-5">
                        <span class="text-gray-300 text-xs mr-0 mt-1">{{ link.views }}</span>
                        <ArrowTrendingUpIcon class="h-4 w-4 text-gray-300 mr-3 ml-0 mt-1" aria-hidden="true"/>
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <EllipsisVerticalIcon class="h-5 w-5 text-gray-500" aria-hidden="true"/>
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }" @click.prevent="copy(link.slug_url)">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                                <DocumentDuplicateIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                                Copiar
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }" @click.prevent="links.editModalOpen(link)">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                                <PencilIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                                Editar
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }" @click.prevent="links.destroyLink(link)">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                                <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                                Excluir
                                            </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </dl>
            </li>
            <Pagination :pagination="links.pagination" v-if="links.pagination.total > links.pagination.per_page" @paginate="links.indexLinks()" />
        </ul>
        <button v-else @click.prevent="links.addModalOpen()" type="button" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center text-gray-400 hover:border-sky-400 hover:text-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
            <LinkIcon class="h-12 w-12 mx-auto" aria-hidden="true"/>
            <span class="mt-2 block text-sm font-semibold text-gray-900">Criar novo link encurtado</span>
        </button>
    </div>
</template>

<style scoped>

</style>
