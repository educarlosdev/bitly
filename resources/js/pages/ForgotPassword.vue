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
        <img class="mx-auto h-10 w-auto" src="/images/icon.png"
             alt="Bitly"/>
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Recupere a senha da sua
            conta</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="#" method="POST">
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" required=""
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"/>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="flex w-full justify-center rounded-md bg-sky-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                    Enviar link de recuperação por e-mail
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
