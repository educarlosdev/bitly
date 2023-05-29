import {defineStore} from "pinia";
import axios from "axios";
import Swal from "sweetalert2";
import {useAuthStore} from "./auth";
import {useUserStore} from "./user";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
if (localStorage.getItem('accessToken')) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`;
}

export const useAvatarStore = defineStore('avatar', {
    state: () => ({
        data: {},
        errors: {},
    }),
    actions: {
        storeAvatar(payload) {
            Swal.fire({
                icon: 'info',
                title: 'Fazendo upload da foto de perfil, por favor aguarde!',
                showConfirmButton: false
            })
            let formData = new FormData();
            formData.append(`avatar`, payload.avatar);
            axios.post(`/api/avatar`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                useAuthStore().me = response.data
                useUserStore().data = response.data
                setTimeout(() => {
                    Swal.close();
                }, 600);
            }).catch(error => {
                this.postLogout();
            });
        },
        destroyAvatar() {
            Swal.fire({
                icon: 'info',
                title: 'Deletando foto de perfil, por favor aguarde!',
                showConfirmButton: false
            })
            axios.delete(`/api/avatar/${useAuthStore().me.id}`).then(response => {
                useAuthStore().me = response.data
                useUserStore().data = response.data
                setTimeout(() => {
                    Swal.close();
                }, 600);
            }).catch(error => {
                this.postLogout();
            });
        },
    }
})
