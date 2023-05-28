<script setup>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions
} from '@headlessui/vue'
import {useLinkStore} from "../store/link";

const links = useLinkStore();

const url = document.location.origin;

import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const fields = [
    { id: 'created_at', name: 'Data de criação' },
    { id: 'updated_at', name: 'Data de atualização' },
    { id: 'url', name: 'URL' },
    { id: 'slug', name: 'Identificador' },
    { id: 'views', name: 'Visualizações' },
]
const directions = [
    { id: 'ASC', name: 'Ascendente' },
    { id: 'DESC', name: 'Descendente' },
]

const order = () => {
    links.linkOrderModalOpen = false;
    links.pagination.current_page = 1;
    links.indexLinks();
}
</script>

<template>
    <TransitionRoot as="template" :show="links.linkOrderModalOpen">
        <Dialog as="div" class="relative z-10">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                             leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                                     enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                     leave-from="opacity-100 translate-y-0 sm:scale-100"
                                     leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Ordernação
                            </DialogTitle>
                            <div class="m-5">
                                <div class="col-span-full">
                                    <Listbox as="div" v-model="links.order">
                                        <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">
                                            Campo
                                        </ListboxLabel>
                                        <div class="relative mt-2">
                                            <ListboxButton
                                                class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-600 sm:text-sm sm:leading-6">
                                                <span class="block truncate">{{ fields.find(item => item.id === links.order).name }}</span>
                                                <span
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
          <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
        </span>
                                            </ListboxButton>

                                            <transition leave-active-class="transition ease-in duration-100"
                                                        leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions
                                                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                    <ListboxOption as="template" v-for="item in fields" :key="item.id" :value="item.id" v-slot="{ active, selected }">
                                                        <li :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ item.name }}</span>

                                                            <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
                                                        </li>
                                                    </ListboxOption>
                                                </ListboxOptions>
                                            </transition>
                                        </div>
                                    </Listbox>
                                </div>
                            </div>
                            <div class="m-5">
                                <div class="col-span-full">
                                    <Listbox as="div" v-model="links.direction">
                                        <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">
                                            Ordem
                                        </ListboxLabel>
                                        <div class="relative mt-2">
                                            <ListboxButton
                                                class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-600 sm:text-sm sm:leading-6">
                                                <span class="block truncate">{{ directions.find(item => item.id === links.direction).name }}</span>
                                                <span
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
          <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
        </span>
                                            </ListboxButton>

                                            <transition leave-active-class="transition ease-in duration-100"
                                                        leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions
                                                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                    <ListboxOption as="template" v-for="item in directions" :key="item.id" :value="item.id" v-slot="{ active, selected }">
                                                        <li :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ item.name }}</span>

                                                            <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
                                                        </li>
                                                    </ListboxOption>
                                                </ListboxOptions>
                                            </transition>
                                        </div>
                                    </Listbox>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="button"
                                        class="inline-flex w-full justify-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 sm:ml-3 sm:w-auto"
                                        @click="order()">Ordenar
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>

</style>
