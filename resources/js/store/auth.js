import {defineStore} from "pinia";
import axios from "axios";
import router from '../router'
import Swal from "sweetalert2";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
if (localStorage.getItem('accessToken')) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`;
}

export const useAuthStore = defineStore('realtorAuth', {
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
            }).catch(error => {
                if (error.response.data.message === 'Your email address is not verified.' && error.response.status === 403) {
                    router.push({name: 'VerifyEmail'});
                } else {
                    this.postLogout();
                }
            });
        },
        updateUser(payload) {
            axios.put(`/api/auth/${payload.id}`, payload).then(response => {
                this.me = response.data;
                this.errors = {};
                Swal.fire({
                    icon: 'success',
                    title: 'Atualizado com sucesso!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    this.postLogout();
                }
            });
        },
        destroyUser(payload) {
            Swal.fire({
                icon: 'info',
                title: 'Deletando sua conta, por favor aguarde!',
                showConfirmButton: false
            });
            axios.delete(`/api/auth/${payload.id}`).then(response => {
                setTimeout(() => {
                    Swal.close();
                    this.postLogout();
                }, 2000);
            }).catch(error => {
                this.postLogout();
            });
        },
        postLogin() {
            axios.post('/api/auth/login', this.login).then(response => {
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
                this.register = {};
                this.errors = {};
                Swal.fire({
                    icon: 'success',
                    title: 'Verifique a caixa de mensagem em seu e-mail e confirme sua conta.',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 5000
                }).then(() => {
                    this.postLogout();
                    router.push({name: 'VerifyEmail'});
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
        storeProfileImage(payload) {
            Swal.fire({
                icon: 'info',
                title: 'Fazendo upload da foto de perfil, por favor aguarde!',
                showConfirmButton: false
            })
            let formData = new FormData();
            formData.append(`profileImage`, payload.profileImage);
            axios.post(`/api/auth/profile-image`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                this.me = response.data
                setTimeout(() => {
                    Swal.close();
                }, 2000);
            }).catch(error => {
                this.postLogout();
            });
        },
        destroyProfileImage(payload) {
            Swal.fire({
                icon: 'info',
                title: 'Deletando foto de perfil, por favor aguarde!',
                showConfirmButton: false
            })
            axios.post(`/api/auth/profile-image`, payload).then(response => {
                this.me = response.data
                setTimeout(() => {
                    Swal.close();
                }, 1000);
            }).catch(error => {
                this.postLogout();
            });
        },
        postChangePassword(payload) {
            axios.post(`/api/auth/change-password`, payload).then(response => {
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
