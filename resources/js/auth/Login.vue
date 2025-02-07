<script setup lang="ts">
import { useAuthStore } from "@stores/auth"
import { useTokenClient } from "vue3-google-signin";

const authStore = useAuthStore()

const handleOnSuccess = (response) => {
    authStore.loginGoogle(response.access_token)
};

const handleOnError = (errorResponse) => {
    console.log("Error: ", errorResponse);
};

const { login } = useTokenClient({
    onSuccess: handleOnSuccess,
    onError: handleOnError,
});

</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="flex w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Side Image -->
            <div class="hidden md:block md:w-1/2 bg-cover bg-center">
                <div class="h-full bg-gray-300 bg-opacity-50 flex items-center justify-center">
                    <h2 class="text-gray-500 text-3xl font-bold text-start px-5">
                        <span class="text-blue-700 font-bold text-4xl">Light</span>
                        <span class="text-green-700 font-bold text-3xl">House</span>
                        <p class="m-0 p-0 text-sm text-gray-500">Site Performance Checker</p>
                    </h2>
                </div>
            </div>

            <!-- Login Form -->
            <div class="w-full md:w-1/2 p-8">
                <div class="max-w-md mx-auto">
                    <div class="text-center">
                        <img class="mx-auto h-12 w-auto" src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png" alt="Google Logo">
                        <h2 class="mt-6 text-center text-xl font-extrabold text-gray-900">
                            Sign in to your account
                        </h2>
                    </div>
                    <button @click="login"
                            id="google-signin-button"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mt-8"
                    >
                        Sign in with Google
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
