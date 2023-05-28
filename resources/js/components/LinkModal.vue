<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {useLinkStore} from "../store/link";

const links = useLinkStore();

const url = document.location.origin;
</script>

<template>
    <TransitionRoot as="template" :show="links.linkModalOpen">
        <Dialog as="div" class="relative z-10" @close="links.linkModalOpen = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <DialogTitle v-if="links.data.id" as="h3" class="text-base font-semibold leading-6 text-gray-900">Editar Link</DialogTitle>
                            <DialogTitle v-else as="h3" class="text-base font-semibold leading-6 text-gray-900">Adicionar Link</DialogTitle>
                            <div class="m-5">
                                <div class="col-span-full">
                                    <label for="url" class="block text-sm font-medium leading-6 text-gray-500">URL</label>
                                    <div class="mt-2">
                                        <input v-model="links.data.url" id="url" name="url" type="url" autocomplete="url" class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-500 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6 placeholder-gray-300" placeholder="https://google.com.br" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label for="slug" class="block text-sm font-medium leading-6 text-gray-500">Identificador (opcional)</label>
                                    <div class="mt-2">
                                        <div class="flex rounded-md bg-white/5 ring-1 ring-inset ring-gray-500 focus-within:ring-2 focus-within:ring-inset focus-within:ring-sky-500">
                                            <span class="flex select-none items-center pl-3 text-sky-500 sm:text-sm">{{ url }}/</span>
                                            <input v-model="links.data.slug" type="text" name="slug" id="slug" autocomplete="slug" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-500 focus:ring-0 sm:text-sm sm:leading-6 placeholder-gray-300" placeholder="eduardo" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button v-if="links.data.id" type="button" class="inline-flex w-full justify-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 sm:ml-3 sm:w-auto" @click="links.updateLink()">Salvar</button>
                                <button v-else type="button" class="inline-flex w-full justify-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 sm:ml-3 sm:w-auto" @click="links.storeLink()">Cadastrar</button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="links.linkModalOpen = false" ref="cancelButtonRef">Fechar</button>
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
