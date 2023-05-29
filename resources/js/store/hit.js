import {defineStore} from "pinia";
import axios from "axios";
import {useAuthStore} from "./auth";
import Swal from "sweetalert2";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
if (localStorage.getItem('accessToken')) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`;
}

export const useHitStore = defineStore('hit', {
    state: () => ({
        search: '',
        pagination: {},
        hitOrderModalOpen: false,
        order: 'created_at',
        direction: 'DESC',
        export: false,
    }),
    actions: {
        indexHits() {
            const page = this.pagination.current_page === 1 ? {} : {page: this.pagination.current_page};
            const search = this.search === '' ? {} : {q: this.search};
            const exporting = this.export ? {export: true} : {};
            if(this.export) {
                Swal.fire({
                    icon: 'info',
                    title: 'Exportando...',
                    showConfirmButton: false
                });
            }
            axios.get('/api/hits', {
                params: {
                    order: this.order,
                    direction: this.direction,
                    ...page,
                    ...search,
                    ...exporting,
                }
            }).then(response => {
                if (this.export) {
                    window.open(response.data, '_blank').focus();
                    this.export = false;
                    Swal.close();
                } else {
                    this.pagination = response.data
                }
            }).catch(error => {
                this.export = false;
                useAuthStore().postLogout();
            });
        },
        showHit(payload) {
            const page = this.pagination.current_page === 1 ? {} : {page: this.pagination.current_page};
            const search = this.search === '' ? {} : {q: this.search};
            const exporting = this.export ? {export: true} : {};
            if(this.export) {
                Swal.fire({
                    icon: 'info',
                    title: 'Exportando...',
                    showConfirmButton: false
                });
            }
            axios.get(`/api/hits/${payload}`, {
                params: {
                    order: this.order,
                    direction: this.direction,
                    ...page,
                    ...search,
                    ...exporting,
                }
            }).then(response => {
                if (this.export) {
                    window.open(response.data, '_blank').focus();
                    this.export = false;
                    Swal.close();
                } else {
                    this.pagination = response.data
                }
            }).catch(error => {
                this.export = false;
                useAuthStore().postLogout();
            });
        },
    }
})
