// import './bootstrap';
import router from "./router/index.js"
import GoogleSignInPlugin from "vue3-google-signin"
import { createApp } from "vue";
import { createPinia } from 'pinia'

import App from "./App.vue";

// axios
import axios from "./axios.js"

const pinia = createPinia()

const app = createApp(App)
app.use(pinia)
app.use(router)
app.provide('axios',axios)
app.use(GoogleSignInPlugin,{
    clientId:"156215430484-gofp82pmualf1h5mh3g48k7rb1v40dqk.apps.googleusercontent.com"
})

app.config.globalProperties.axios = { ...axios }
app.mount('#app')
