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

export const useLinkStore = defineStore('link', {
    state: () => ({
        search: '',
        pagination: {},
        data: {},
        errors: {},
        linkModalOpen: false,
        linkOrderModalOpen: false,
        order: 'created_at',
        direction: 'DESC',
    }),
    actions: {
        indexLinks() {
            const page = this.pagination.current_page === 1 ? {} : {page: this.pagination.current_page};
            const search = this.search === '' ? {} : {q: this.search};
            axios.get('/api/links', {
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
        storeLink() {
            if (this.data.slug === '') delete this.data.slug;
            axios.post(`/api/links`, this.data).then(response => {
                this.linkModalOpen = false
                this.indexLinks();
                this.errors = {};
                Swal.fire({
                    icon: 'success',
                    title: 'Cadastrado com sucesso!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    useAuthStore().postLogout();
                }
            });
        },
        showLink(payload) {
            axios.get(`/api/links/${payload}`).then(response => {
                this.data = response.data
            }).catch(error => {
                useAuthStore().postLogout();
            });
        },
        updateLink() {
            if (this.data.slug === '') delete this.data.slug;
            axios.put(`/api/links/${this.data.id}`, this.data).then(response => {
                this.linkModalOpen = false
                this.indexLinks();
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
        destroyLink(payload) {
            Swal.fire({
                title: 'Você tem certeza que deseja excluir esse link?',
                text: "Ao excluir você perderá os dados deste link!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sim, Remover!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/links/${payload.id}`).then(response => {
                        this.indexLinks();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deletado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }).catch(error => {
                        useAuthStore().postLogout();
                    });
                }
            });
        },
        destroyLinksAll() {
            Swal.fire({
                title: 'Você tem certeza que deseja excluir todos os link?',
                text: "Ao excluir você perderá os dados de todos links!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sim, Remover!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/links/all`).then(response => {
                        this.indexLinks();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deletado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }).catch(error => {
                        useAuthStore().postLogout();
                    });
                }
            });
        },
        addModalOpen() {
            this.data = {};
            this.linkModalOpen = true
        },
        editModalOpen(payload) {
            this.data = JSON.parse(JSON.stringify(payload));
            this.linkModalOpen = true
        }
    }
})
