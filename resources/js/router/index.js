import {createMemoryHistory, createRouter, createWebHistory} from 'vue-router'


import Login from "../auth/Login.vue";
import Home from "../Home.vue";
import {useAuthStore} from "@/stores/auth.js";


const routes = [
    { path: '/', component: Home,meta:{auth:true}, name: 'home' },
    { path: '/auth/login', component: Login, meta:{guest:true}, name:'login' },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})


// Route Guards
router.beforeEach((to, from, next) => {
    const isAuthenticated = (useAuthStore().isAuthenticated());

    if (to.meta.auth && !isAuthenticated) {
        next('/auth/login');
    } else if (to.meta.guest && isAuthenticated) {
        next('/');
    } else {
        next();
    }
});
export default router;
