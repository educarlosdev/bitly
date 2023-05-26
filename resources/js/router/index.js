import {createRouter, createWebHistory} from "vue-router"

import NotFound from "../pages/NotFound.vue";
import AppLayout from "../layout/AppLayout.vue";
import AuthLayout from "../layout/AuthLayout.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import ForgotPassword from "../pages/ForgotPassword.vue";
import Dashboard from "../pages/Dashboard.vue";

const routes = [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                path: '/dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: {
                    requiresAuth: true,
                    routeLogin: 'Login'
                }
            },
        ],
    },
    {
        path: '/',
        component: AuthLayout,
        children: [
            {
                path: '/login',
                name: 'Login',
                component: Login,
                meta: {
                    requiresAuth: false,
                    routeDashboard: 'Dashboard'
                }
            },
            {
                path: '/register',
                name: 'Register',
                component: Register,
                meta: {
                    requiresAuth: false,
                    routeDashboard: 'Dashboard'
                }
            },
            {
                path: '/forgot-password',
                name: 'ForgotPassword',
                component: ForgotPassword,
                meta: {
                    requiresAuth: false,
                    routeDashboard: 'Dashboard'
                }
            },
            // {
            //     path: '/reset-password',
            //     name: 'ResetPassword',
            //     component: ResetPassword,
            //     meta: {
            //         requiresAuth: false,
            //         routeDashboard: 'Dashboard'
            //     }
            // },
            // {
            //     path: '/verify-email',
            //     name: 'VerifyEmail',
            //     component: VerifyEmail,
            //     meta: {
            //         requiresAuth: true,
            //         routeDashboard: 'Login'
            //     }
            // },
        ],
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound,
        meta: {
            requiresAuth: false
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem("accessToken")) {
        localStorage.setItem('back_redirect', window.location.href);
        return {
            name: to.meta.routeLogin
        }
    }
    if (to.meta.requiresAuth === false && localStorage.getItem("accessToken")) {
        return {
            name: to.meta.routeDashboard
        }
    }
});

export default router;
