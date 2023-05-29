<script setup>
import {useAuthStore} from "../store/auth";
import {onMounted} from "vue";

const auth = useAuthStore();

onMounted(() => {
    auth.errors = [];
})

</script>

<template>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="../../assets/images/icon.png"
             alt="Bitly"/>
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Faça o cadastro da sua
            conta</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="#" method="POST">
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Nome</label>
                <div class="mt-2">
                    <div class="relative">
                        <input v-model="auth.register.name" id="name" name="name" type="text" autocomplete="name"
                               required="" :class="auth.errors.name ? 'border-red-300' : ''" placeholder="Nome"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"/>
                        <div v-show="auth.errors.name"
                             class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 animate-in-left">
                            <i class='bx bxs-error-circle text-red-500' aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <p v-if="auth.errors.name" class="mt-1 text-sm text-red-600 animate-in-left">
                    {{ auth.errors.name.join(" ") }}</p>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">E-mail</label>
                <div class="mt-2">
                    <div class="relative">
                        <input v-model="auth.register.email" id="email" name="email" type="email" autocomplete="email"
                               required="" :class="auth.errors.email ? 'border-red-300' : ''" placeholder="E-mail"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"/>
                        <div v-show="auth.errors.email"
                             class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 animate-in-left">
                            <i class='bx bxs-error-circle text-red-500' aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <p v-if="auth.errors.email" class="mt-1 text-sm text-red-600 animate-in-left">
                    {{ auth.errors.email.join(" ") }}</p>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Senha</label>
                </div>
                <div class="mt-2">
                    <div class="relative">
                        <input v-model="auth.register.password" id="password" name="password" type="password"
                               autocomplete="current-password" required="" placeholder="Senha"
                               :class="auth.errors.password ? 'pr-9' : 'pr-3'"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"/>
                        <div v-show="auth.errors.password"
                             class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 animate-in-left">
                            <i class='bx bxs-error-circle text-red-500' aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <p v-if="auth.errors.password" class="mt-1 text-sm text-red-600 animate-in-left">
                    {{ auth.errors.password.join(" ") }}</p>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password-confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirme a senha</label>
                </div>
                <div class="mt-2">
                    <div class="relative">
                        <input v-model="auth.register.password_confirmation" id="password-confirmation" name="password-confirmation" type="password"
                               autocomplete="password-confirmation" required="" placeholder="Confirme a senha"
                               :class="auth.errors.password ? 'pr-9' : 'pr-3'"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"/>
                        <div v-show="auth.errors.password"
                             class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 animate-in-left">
                            <i class='bx bxs-error-circle text-red-500' aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <p v-if="auth.errors.password" class="mt-1 text-sm text-red-600 animate-in-left">
                    {{ auth.errors.password.join(" ") }}</p>
            </div>

            <div>
                <button type="submit" @click.prevent="auth.postRegister"
                        class="flex w-full justify-center rounded-md bg-sky-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                    Cadastrar
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Já é um membro?
            {{ ' ' }}
            <router-link :to="{name: 'Login'}" class="font-semibold leading-6 text-sky-600 hover:text-sky-500">
                Faça o login
            </router-link>
        </p>
    </div>
</template>

<style scoped>

</style>
