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
        <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
             alt="Bitly"/>
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Faça login em sua
            conta</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="#" method="POST">
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                <div class="mt-2">
                    <input v-model="auth.login.email" id="email" name="email" type="email" autocomplete="email" required="" :class="auth.errors.email ? 'border-red-300' : ''"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                    <div v-show="auth.errors.email" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 animate-in-left">
                        <i class='bx bxs-error-circle text-red-500' aria-hidden="true"></i>
                    </div>
                </div>
                <p v-if="auth.errors.email" class="mt-1 text-sm text-red-600 animate-in-left">{{ auth.errors.email.join(" ") }}</p>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Senha</label>
                    <div class="text-sm">
                        <router-link :to="{name: 'ForgotPassword'}" class="font-semibold text-indigo-600 hover:text-indigo-500">Esqueceu sua senha?</router-link>
                    </div>
                </div>
                <div class="mt-2">
                    <input v-model="auth.login.password" id="password" name="password" type="password" autocomplete="current-password" required="" :class="auth.errors.password ? 'pr-9' : 'pr-3'"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                    <div v-show="auth.errors.password" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 animate-in-left">
                        <i class='bx bxs-error-circle text-red-500' aria-hidden="true"></i>
                    </div>
                </div>
                <p v-if="auth.errors.password" class="mt-1 text-sm text-red-600 animate-in-left">{{ auth.errors.password.join(" ") }}</p>
            </div>

            <div>
                <button type="submit" @click.prevent="auth.postLogin"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Entrar
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Não é um membro?
            {{ ' ' }}
            <router-link :to="{name: 'Register'}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
                Cadastra-se
            </router-link>
        </p>
    </div>
</template>

<style scoped>

</style>
