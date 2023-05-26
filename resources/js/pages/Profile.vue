<script setup>
import {useAuthStore} from "../store/auth";

const auth = useAuthStore();
</script>

<template>
    <div>
        <div class="xl:pl-72">
            <!-- Settings forms -->
            <div class="divide-y divide-gray-200">
                <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-500">Informações pessoais</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Mantenha sempre atualizado suas informações.</p>
                    </div>

                    <form class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="col-span-full flex items-center gap-x-8">
                                <img
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="" class="h-24 w-24 flex-none rounded-lg bg-gray-800 object-cover"/>
                                <div>
                                    <button type="button"
                                            class="rounded-md px-3 py-2 text-sm font-semibold text-gray-500 shadow hover:bg-white">
                                        Alterar avatar
                                    </button>
                                    <p class="mt-2 text-xs leading-5 text-gray-400">JPG, GIF or PNG. 5MB max.</p>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-500">Nome</label>
                                <div class="mt-2">
                                    <input v-model="auth.me.name" id="name" name="name" type="text" autocomplete="name" placeholder="Nome"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6"/>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label class="block text-sm font-medium leading-6 text-gray-500">Email</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-sky-500 py-2">
                                        <span class="flex select-none items-center pl-3 text-gray-400 sm:text-sm">{{
                                                auth.me.email
                                            }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex">
                            <button type="submit"
                                    class="rounded-md bg-sky-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-500">Alterar senha</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Altere a senha associada à sua conta.</p>
                    </div>

                    <form class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="current-password" class="block text-sm font-medium leading-6 text-gray-500">Senha
                                    atual</label>
                                <div class="mt-2">
                                    <input v-model="auth.changePassword.current_password" id="current-password" name="current_password" type="password"
                                           autocomplete="current-password" placeholder="Senha atual"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6"/>
                                </div>
                                <p v-if="auth.errors.current_password" class="mt-1 text-sm text-red-600 animate-in-left">
                                    {{ auth.errors.current_password.join(" ") }}</p>
                            </div>

                            <div class="col-span-full">
                                <label for="new-password" class="block text-sm font-medium leading-6 text-gray-500">Nova
                                    senha</label>
                                <div class="mt-2">
                                    <input v-model="auth.changePassword.password" id="new-password" name="new_password" type="password"
                                           autocomplete="new-password" placeholder="Nova senha"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6"/>
                                </div>
                                <p v-if="auth.errors.password" class="mt-1 text-sm text-red-600 animate-in-left">
                                    {{ auth.errors.password.join(" ") }}</p>
                            </div>

                            <div class="col-span-full">
                                <label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-500">Confirme a nova senha</label>
                                <div class="mt-2">
                                    <input v-model="auth.changePassword.password_confirmation" id="confirm-password" name="confirm_password" type="password"
                                           autocomplete="new-password" placeholder="Confirme a nova senha"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6"/>
                                </div>
                                <p v-if="auth.errors.password" class="mt-1 text-sm text-red-600 animate-in-left">
                                    {{ auth.errors.password.join(" ") }}</p>
                            </div>
                        </div>

                        <div class="mt-8 flex">
                            <button type="submit" @click.prevent="auth.postChangePassword()"
                                    class="rounded-md bg-sky-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">
                                Alterar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-500">Deletar conta</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Não quer mais usar nosso serviço? Você pode
                            excluir sua conta aqui. Esta ação não é reversível. Todas as informações relacionadas a esta
                            conta serão excluídas permanentemente.</p>
                    </div>

                    <form class="flex items-start md:col-span-2">
                        <button type="submit"
                                class="rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-400">
                            Sim, excluir minha conta!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
