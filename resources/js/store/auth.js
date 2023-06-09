import {defineStore} from "pinia";
import axios from "axios";
import router from '../router'
import Swal from "sweetalert2";
import {useUserStore} from "./user";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
if (localStorage.getItem('accessToken')) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`;
}

export const useAuthStore = defineStore('auth', {
    state: () => ({
        me: {},
        login: {},
        register: {},
        forgotPassword: {},
        resetPassword: {},
        changePassword: {},
        errors: {},
    }),
    actions: {
        getMe() {
            axios.get('/api/auth/me').then(response => {
                this.me = response.data;
                useUserStore().data = response.data;
            }).catch(error => {
                this.postLogout();
            });
        },
        postLogin() {
            axios.post('/api/auth/login', this.login).then(response => {
                this.login = {};
                localStorage.setItem("accessToken", response.data.access_token);
                if (localStorage.getItem('back_redirect')) {
                    window.location.href = localStorage.getItem('back_redirect');
                    localStorage.removeItem('back_redirect');
                } else {
                    router.push({name: 'Dashboard'});
                }
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    this.postLogout();
                }
            });
        },
        postLogout() {
            localStorage.setItem('back_redirect', window.location.href);
            axios.post('/api/auth/logout').then(response => {
                localStorage.removeItem('accessToken');
                router.push({name: 'Login'});
            }).catch(error => {
                localStorage.removeItem('accessToken');
                router.push({name: 'Login'});
            });
        },
        postRegister() {
            axios.post('/api/auth/register', this.register).then(response => {
                this.login = {
                    email: this.register.email,
                    password: this.register.password,
                };
                this.register = {};
                this.errors = {};
                Swal.fire({
                    icon: 'success',
                    title: 'Cadastrado realizado com sucesso!',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 1000
                }).then(() => {
                    this.postLogin();
                });
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors
                } else {
                    this.postLogout();
                }
            });
        },
        postForgotPassword() {
            axios.post('/api/auth/forgot-password', this.forgotPassword).then(response => {
                this.forgotPassword = {};
                this.errors = {};
                Swal.fire({
                    icon: 'success',
                    title: response.data.status,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 5000
                }).then(() => {
                    router.push({name: 'Login'});
                });
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else if (error.response.data.status) {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.status,
                        showConfirmButton: false,
                        timer: 5000
                    });
                } else {
                    this.postLogout();
                }
            });
        },
        postResetPassword() {
            axios.post('/api/auth/reset-password', this.resetPassword).then(response => {
                this.resetPassword = {};
                this.errors = {};
                Swal.fire({
                    icon: 'success',
                    title: response.data.status,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 5000
                }).then(() => {
                    router.push({name: 'Login'});
                });
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors
                } else if (error.response.data.status) {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.status,
                        showConfirmButton: false,
                        timer: 5000
                    })
                } else {
                    this.postLogout();
                }
            });
        },
        postChangePassword() {
            axios.post(`/api/auth/change-password`, this.changePassword).then(response => {
                this.changePassword = {}
                this.errors = {}
                Swal.fire({
                    icon: 'success',
                    title: 'Senha alterada com sucesso!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors
                } else {
                    this.postLogout();
                }
            });
        },
    }
})
