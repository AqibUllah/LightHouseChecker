import { defineStore } from 'pinia'
import {ref,computed} from "vue"
import router from "@/router/index.js";

import axios from "@/axios.js"
export const useAuthStore = defineStore('counter', () => {
    const user = ref(null)
    const loading = ref(false)
    const loginGoogle = async (token) => {
        loading.value = true
        await axios.post('auth/google/login', {
            token: token,
        })
        .then((res) => {
            user.value = res.data.user
            localStorage.setItem('token',token)
            router.push({name : 'home'})
        })
        .catch((err) => {
            console.log(err)
        }).finally(() => loading.value = false)
    }

    const logout = () => {
        localStorage.removeItem('token')
        user.value = null
        router.push({name: 'login'})
    }

    const isAuthenticated = () => !!user.value

    return { loginGoogle, loading, user, logout, isAuthenticated }
})
