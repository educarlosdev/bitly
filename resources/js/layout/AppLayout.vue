<script setup>
import {onMounted} from "vue";
import {useAuthStore} from "../store/auth";
import Navbar from "../components/Navbar.vue";
import LinkModal from "../components/LinkModal.vue";

const auth = useAuthStore();

onMounted(() => {
    auth.getMe();
});
</script>

<template>
    <Navbar/>
    <main>
        <router-view/>
    </main>
    <LinkModal />
</template>


<style scoped>

</style>
