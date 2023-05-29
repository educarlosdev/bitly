import {defineStore} from "pinia";
import axios from "axios";
import {useAuthStore} from "./auth";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
if (localStorage.getItem('accessToken')) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`;
}

export const useDashboardStore = defineStore('dashboard', {
    state: () => ({
        metrics: {},
    }),
    actions: {

        showMetrics() {
            axios.get(`/api/dashboard/metrics`).then(response => {
                this.metrics = response.data
            }).catch(error => {
                useAuthStore().postLogout();
            });
        },
    }
})
