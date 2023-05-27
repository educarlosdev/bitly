import {createRouter, createWebHistory} from "vue-router"

import NotFound from "../pages/NotFound.vue";
import AppLayout from "../layout/AppLayout.vue";
import AuthLayout from "../layout/AuthLayout.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import ForgotPassword from "../pages/ForgotPassword.vue";
import Dashboard from "../pages/Dashboard.vue";
import Profile from "../pages/Profile.vue";

const routes = [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                path: 'admin/dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: {
                    requiresAuth: true,
                    routeLogin: 'Login'
                }
            },
            {
                path: 'admin/profile',
                name: 'Profile',
                component: Profile,
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
                path: 'admin/login',
                name: 'Login',
                component: Login,
                meta: {
                    requiresAuth: false,
                    routeDashboard: 'Dashboard'
                }
            },
            {
                path: 'admin/register',
                name: 'Register',
                component: Register,
                meta: {
                    requiresAuth: false,
                    routeDashboard: 'Dashboard'
                }
            },
            {
                path: 'admin/forgot-password',
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
