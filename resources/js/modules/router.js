import { createRouter, createWebHistory } from 'vue-router';
import loader from './loader';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () =>import('../components/RecipeList.vue'),
    },
    {
        path: '/recipe/rec/:id',
        name: 'RecipeCard',
        component: () =>import('../components/RecipeCard.vue'),
    },
    {
        path: '/recipe/index',
        name: 'RecipeList',
        component: () =>import('../components/RecipeList.vue'),
    },
    {
        path: '/login',
        name: 'Login',
        component: () =>import('../components/Login.vue'),
    },
    {
        path: '/registration',
        name: 'Registration',
        component: () =>import('../components/Registration.vue'),
    },
    {
        path: '/verification/:email',
        name: 'EmailVerification',
        component: () =>import('../components/EmailVerification.vue'),
    },
    {
        path: '/password/forgot',
        name: 'ForgotPassword',
        component: () =>import('../components/ForgotPassword.vue'),
    },
    {
        path: '/password-reset/:token',
        name: 'NewPassword',
        component: () =>import('../components/NewPassword.vue'),
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if (to.path !== from.path) {
        loader.showLoader(to.name);
    }
    next();
});

router.afterEach((to, from) => {
    loader.hideLoader(to.name);
});

export default router
