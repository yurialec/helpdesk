<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 text-md-start text-center mb-2 mb-md-0">
                        <h3>Iniciar Chat</h3>
                    </div>
                    <div class="col-12 col-md-6 text-md-end text-center mb-2 mb-md-0">
                        <a class="btn" data-toggle="tooltip" title="Transferir para outro atendente">
                            <i style="color:#87CEFA;" class="bi bi-person-fill-gear h2"></i>
                            <p><small>Alterar atendente</small></p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="loading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div style="background-color: red;">
                    Oi
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import dayjs from 'dayjs';

export default {
    props: {
        urlInitiateChat: String,
    },
    data() {
        return {
            chats: {
                data: [],
                links: []
            },
            searchFilter: '',
            alertStatus: null,
            msg: [],
            loading: null,
        };
    },
    mounted() {
        this.getChats();
    },
    methods: {
        pesquisar() {
            this.getChats('admin/chat/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getChats(url);
            }
        },
        getChats(url = 'admin/chat/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.chats = response.data.chats;
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false
                });
        },
        formatDate(date) {
            return dayjs(date).format('DD/MM/YYYY HH:mm:ss');
        }
    }
}
</script>