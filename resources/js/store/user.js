import {defineStore} from "pinia";
import axios from "axios";
import Swal from "sweetalert2";
import {useAuthStore} from "./auth";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
if (localStorage.getItem('accessToken')) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`;
}

export const useUserStore = defineStore('user', {
    state: () => ({
        data: {},
        errors: {},
    }),
    actions: {
        updateUser() {
            axios.put(`/api/user/${this.data.id}`, {name: this.data.name}).then(response => {
                this.data = response.data;
                useAuthStore().me = response.data;
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
                    useAuthStore().postLogout();
                }
            });
        },
        destroyUser() {
            Swal.fire({
                icon: 'info',
                title: 'Deletando sua conta, por favor aguarde!',
                showConfirmButton: false
            });
            axios.delete(`/api/user/${this.data.id}`).then(response => {
                useAuthStore().postLogout();
                setTimeout(() => {
                    Swal.close();
                }, 1000);
            }).catch(error => {
                this.postLogout();
            });
        },
    }
})
