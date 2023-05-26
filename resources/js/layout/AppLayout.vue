<script setup>
import {onMounted} from "vue";
import {useAuthStore} from "../store/auth";
import Stats from "../components/Stats.vue";
import Navbar from "../components/Navbar.vue";
import Header from "../components/Header.vue";
import Divider from "../components/Divider.vue";

const auth = useAuthStore();

onMounted(() => {
    auth.getMe();
});
</script>

<template>
    <Navbar/>
    <Stats/>
    <Divider/>
    <Header/>
    <main class="py-3">
        <router-view/>
    </main>
</template>


<style scoped>

</style>
