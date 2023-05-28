import {defineStore} from "pinia";
import axios from "axios";
import {useAuthStore} from "./auth";

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
    }),
    actions: {
        indexHits() {
            const page = this.pagination.current_page === 1 ? {} : {page: this.pagination.current_page};
            const search = this.search === '' ? {} : {q: this.search};
            axios.get('/api/hits', {
                params: {
                    order: this.order,
                    direction: this.direction,
                    ...page,
                    ...search,
                }
            }).then(response => {
                this.pagination = response.data
            }).catch(error => {
                // useAuthStore().postLogout();
            });
        },
        showHit(payload) {
            axios.get(`/api/hits/${payload}`).then(response => {
                this.data = response.data
            }).catch(error => {
                useAuthStore().postLogout();
            });
        },
    }
})
