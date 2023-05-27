<script setup>
import {useAuthStore} from "../store/auth";
import {useUserStore} from "../store/user";
import Swal from "sweetalert2";
import {useAvatarStore} from "../store/avatar";

const auth = useAuthStore();
const avatar = useAvatarStore();
const user = useUserStore();

const openInputFile = () => {
    document.getElementById('avatar').click()
}

const storeAvatar = event => {
    if (event.target.files.length === 1) {
        avatar.storeAvatar({
            avatar: event.target.files[0],
        });
    }
}

const deleteAvatar = () => {
    Swal.fire({
        title: 'Remover foto de perfil?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Sim, Remover!'
    }).then((result) => {
        if (result.isConfirmed) {
            avatar.destroyAvatar();
        }
    });
}

const deleteUser = () => {
    Swal.fire({
        title: 'Você tem certeza que deseja remover sua conta?',
        text: "Ao remover você perderá tudo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Sim, Remover!'
    }).then((result) => {
        if (result.isConfirmed) {
            user.destroyUser();
        }
    })
}
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
                                <img v-if="user.data.avatar_url"
                                     :src="user.data.avatar_url"
                                     alt="" class="h-24 w-24 flex-none rounded-full bg-white object-cover"/>
                                <span v-else class="inline-block h-24 w-24 overflow-hidden rounded-full bg-gray-200">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                      <path
                                          d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                  </span>
                                <div v-if="!user.data.avatar_url">
                                    <button type="button" @click.prevent="openInputFile()"
                                            class="rounded-md px-3 py-2 text-sm font-semibold text-gray-500 shadow hover:bg-white">
                                        Inserir avatar
                                    </button>
                                    <input id="avatar" name="avatar" type="file"
                                           @change.prevent="storeAvatar($event)"
                                           class="absolute h-0 w-0 cursor-pointer rounded-md border-gray-300 opacity-0">
                                    <p class="mt-2 text-xs leading-5 text-gray-400">JPG ou PNG. 10MB máximo.</p>
                                </div>
                                <div v-else>
                                    <button type="button" @click.prevent="deleteAvatar()"
                                            class="rounded-md px-3 py-2 text-sm font-semibold text-gray-500 shadow hover:bg-white">
                                        Remover avatar
                                    </button>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-500">Nome</label>
                                <div class="mt-2">
                                    <input v-model="user.data.name" id="name" name="name" type="text"
                                           autocomplete="name" placeholder="Nome"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6"/>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label class="block text-sm font-medium leading-6 text-gray-500">Email</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-sky-500 py-2">
                                        <span class="flex select-none items-center pl-3 text-gray-400 sm:text-sm">{{
                                                user.data.email
                                            }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex">
                            <button type="submit" @click.prevent="user.updateUser()"
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
                                    <input v-model="auth.changePassword.current_password" id="current-password"
                                           name="current_password" type="password"
                                           autocomplete="current-password" placeholder="Senha atual"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6"/>
                                </div>
                                <p v-if="auth.errors.current_password"
                                   class="mt-1 text-sm text-red-600 animate-in-left">
                                    {{ auth.errors.current_password.join(" ") }}</p>
                            </div>

                            <div class="col-span-full">
                                <label for="new-password" class="block text-sm font-medium leading-6 text-gray-500">Nova
                                    senha</label>
                                <div class="mt-2">
                                    <input v-model="auth.changePassword.password" id="new-password" name="new_password"
                                           type="password"
                                           autocomplete="new-password" placeholder="Nova senha"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:text-sm sm:leading-6"/>
                                </div>
                                <p v-if="auth.errors.password" class="mt-1 text-sm text-red-600 animate-in-left">
                                    {{ auth.errors.password.join(" ") }}</p>
                            </div>

                            <div class="col-span-full">
                                <label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-500">Confirme
                                    a nova senha</label>
                                <div class="mt-2">
                                    <input v-model="auth.changePassword.password_confirmation" id="confirm-password"
                                           name="confirm_password" type="password"
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
                        <button type="submit" @click.prevent="deleteUser"
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
