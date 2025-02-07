<script setup>

import {useAuthStore} from "@/stores/auth.js";
import {ref,computed} from "vue";
import {
    VueSpinner,
} from 'vue3-spinners';
const url = ref('')
const strategy = ref('DESKTOP')

const authStore = useAuthStore()
const score = ref(null)
const user = computed(() => authStore.user)
import axios from "@/axios.js"
import Header from "@/components/Header.vue";
const loading = ref(false)

const getLighthouseScore = async () => {
    if(!loading.value){

        loading.value = true
        try {
            const response = await axios.post('lighthouse', {
                url: url.value,
                strategy: strategy.value,
            });
            score.value = response.data;
            loading.value = false
        } catch (error) {
            loading.value = false
            console.log(error)
        }
    }
}
</script>

<template>
    <Header />
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ user.name }}!</h1>
        </div>

        <!-- Lighthouse Form -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Get Lighthouse Performance Score</h2>
            <form @submit.prevent="getLighthouseScore" class="space-y-4">
                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700">Website URL</label>
                    <input
                        v-model="url"
                        type="url"
                        id="url"
                        required
                        placeholder="https://example.com"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                    <select class="w-full rounded-md p-3 my-3" required v-model="strategy" name="strategy" id="frm-whatever">
                        <option value="">Please choose&hellip;</option>
                        <option value="DESKTOP">DESKTOP</option>
                        <option value="MOBILE">MOBILE</option>
                    </select>
                </div>
                <button
                    :disabled="loading"
                    type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
                >
                    Get Score
                </button>
            </form>
        </div>

        <VueSpinner class="mx-auto my-20" size="100" color="blue" v-show="loading" />

        <!-- Lighthouse Results -->
        <div v-if="score && !loading" class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Lighthouse Performance Score ({{ url }})</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-4xl font-bold text-indigo-600">{{ score.performance.value * 100 }}</div>
                    <div class="text-sm text-gray-500">{{ score.performance.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.performance.description }}</p>

                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600">{{ score.First_contentful_paint.value }}</div>
                    <div class="text-sm text-gray-500">{{ score.First_contentful_paint.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.First_contentful_paint.description }}</p>

                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-600">{{ score.time_to_interactive.value }}</div>
                    <div class="text-sm text-gray-500">{{ score.time_to_interactive.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.time_to_interactive.description }}</p>

                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ score.total_blocking_time.value }}</div>
                    <div class="text-sm text-gray-500">{{ score.total_blocking_time.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.total_blocking_time.description }}</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ score.redirects.value * 100 }}</div>
                    <div class="text-sm text-gray-500">{{ score.redirects.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.redirects.description }}</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ score.cumulative_layout_shift.value }}</div>
                    <div class="text-sm text-gray-500">{{ score.cumulative_layout_shift.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.cumulative_layout_shift.description }}</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ score.user_timings.value * 100 }}</div>
                    <div class="text-sm text-gray-500">{{ score.user_timings.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.user_timings.description }}</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ score.server_response_time.value }}</div>
                    <div class="text-sm text-gray-500">{{ score.server_response_time.title }}</div>
                    <p class="text-xs text-gray-400">{{ score.server_response_time.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
