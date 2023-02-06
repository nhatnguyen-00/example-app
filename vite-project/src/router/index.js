import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import DefaultLayout from '../components/DefaultLayout.vue';
import AuthLayout from '../components/AuthLayout.vue';
import Survey from '../views/Survey.vue';
import store from '../store';

const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: '/dashboard',
                name: 'Dashboard',
                component: Dashboard,
            },
            { path: '/survey', name: 'Survey', component: Survey },
        ],
    },
    {
        path: '/auth',
        name: 'Auth',
        redirect: '/login',
        meta: { isGuest: true },
        component: AuthLayout,
        children: [
            { path: '/login', name: 'login', component: Login },
            { path: '/register', name: 'register', component: Register },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    console.log(store.state.user.token);
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'login' });
    } else if (store.state.user.token && to.meta.isGuest) {
        next({ name: 'Dashboard' });
    } else {
        next();
    }
});
export default router;
