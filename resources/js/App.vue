<script setup>

import {useAuthStore} from "@/stores/auth.js";
import {onMounted} from "vue";

const authStore = useAuthStore()

onMounted(async () => {
    if (!authStore.user || !authStore.isAuthenticated()) {
        await authStore.loginGoogle(localStorage.getItem('token'))
    }
})
</script>

<template>
    <router-view />
</template>

<style scoped>

</style>
