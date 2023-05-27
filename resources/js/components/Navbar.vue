<script setup>

import {Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import {Bars3Icon, BellIcon, PlusIcon, XMarkIcon, ChevronDownIcon} from "@heroicons/vue/24/outline";
import {useAuthStore} from "../store/auth";
import {useLinkStore} from "../store/link";
import {watch} from "vue";

const auth = useAuthStore();
const links = useLinkStore();

const navigation = [
    {name: 'Dashboard', to: {name: 'Dashboard'}, current: true},
]
const userNavigation = [
    {name: 'Perfil', to: {name: 'Profile'}},
]

watch(
    () => links.search,
    (search) => {
        if (search === '') {
            links.indexLinks();
        }
    }
)
</script>

<template>
    <Popover as="template" v-slot="{ open }">
        <header
            :class="[open ? 'fixed inset-0 z-40 overflow-y-auto' : '', 'bg-white shadow-sm lg:static lg:overflow-y-visible']">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative flex justify-between lg:gap-8 xl:grid xl:grid-cols-12">
                    <div class="flex md:absolute md:inset-y-0 md:left-0 lg:static xl:col-span-2">
                        <div class="flex flex-shrink-0 items-center text-gray-500 hover:text-gray-900 text-2xl">
                            <router-link :to="{name: 'Dashboard'}" class="flex">
                                <img class="block h-8 w-auto pr-2" src="/images/icon.png" alt="Bitly"/>
                                <span class="hidden lg:flex">
                                    Bitly
                                </span>
                            </router-link>
                        </div>
                    </div>
                    <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6">
                        <div class="flex items-center px-6 py-4 md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0">
                            <div class="w-full">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                    </div>
                                    <input v-model.trim="links.search"
                                           @keyup.enter.exact="links.indexLinks()" id="search" name="search"
                                           class="block w-full rounded-md border-0 bg-gray-100 py-3 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-400 sm:text-sm sm:leading-6"
                                           placeholder="Search" type="search"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center md:absolute md:inset-y-0 md:right-0 lg:hidden">
                        <!-- Mobile menu button -->
                        <PopoverButton
                            class="-mx-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-sky-400">
                            <span class="sr-only">Open menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true"/>
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true"/>
                        </PopoverButton>
                    </div>
                    <div class="hidden lg:flex lg:items-center lg:justify-end xl:col-span-4">
                        <a href="#" @click.prevent="links.addModalOpen()"
                           class="ml-5 flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2">
                            <span class="sr-only">Novo link</span>
                            <PlusIcon class="h-6 w-6" aria-hidden="true"/>
                        </a>
                        <a href="#"
                           class="ml-5 flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2">
                            <span class="sr-only">Ver notificações</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true"/>
                        </a>

                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative ml-5 flex-shrink-0">
                            <div>
                                <MenuButton
                                    class="flex rounded-full bg-white focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2">
                                    <span class="sr-only">Open user menu</span>
                                    <img v-if="auth.me.avatar_url" class="h-8 w-8 rounded-full"
                                         :src="auth.me.avatar_url" alt=""/>
                                    <span v-else class="inline-block h-8 w-8 overflow-hidden rounded-full bg-gray-200">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                      <path
                                          d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                  </span>
                                    <ChevronDownIcon class="relative h-5 w-5 ml-1.5 top-2 text-gray-400"
                                                     aria-hidden="true"/>
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100"
                                        enter-from-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <router-link :to="item.to"
                                                     :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                            {{ item.name }}
                                        </router-link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" @click.prevent="auth.postLogout()"
                                           :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Sair</a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>

            <PopoverPanel as="nav" class="lg:hidden" aria-label="Global">
                <div class="mx-auto max-w-3xl space-y-1 px-2 pb-3 pt-2 sm:px-4">
                    <router-link v-for="item in navigation" :key="item.name" :to="item.to"
                                 :aria-current="item.current ? 'page' : undefined"
                                 :class="[item.current ? 'bg-gray-100 text-gray-900' : 'hover:bg-gray-50', 'block rounded-md py-2 px-3 text-base font-medium']">
                        {{ item.name }}
                    </router-link>
                </div>
                <div class="border-t border-gray-200 pb-3 pt-4">
                    <div class="mx-auto flex max-w-3xl items-center px-4 sm:px-6">
                        <div class="flex-shrink-0">
                            <img v-if="auth.me.avatar_url" class="h-10 w-10 rounded-full" :src="auth.me.avatar_url"
                                 alt=""/>
                            <span v-else class="inline-block h-10 w-10 overflow-hidden rounded-full bg-gray-200">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                      <path
                                          d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                  </span>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ auth.me.name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ auth.me.email }}</div>
                        </div>
                        <button type="button"
                                class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true"/>
                        </button>
                    </div>
                    <div class="mx-auto mt-3 max-w-3xl space-y-1 px-2 sm:px-4">
                        <router-link v-for="item in userNavigation" :key="item.name" :to="item.to"
                                     class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                            {{ item.name }}
                        </router-link>
                        <a href="#" @click.prevent="auth.postLogout()"
                           class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Sair</a>
                    </div>
                </div>
            </PopoverPanel>
        </header>
    </Popover>
</template>

<style scoped>

</style>
