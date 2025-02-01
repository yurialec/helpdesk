<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3 text-md-left text-center mb-2 mb-md-0">
                        <h3>Atendentes</h3>
                    </div>
                    <div class="col-12 col-md-6 text-center mb-2 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="searchFilter" />
                            <button type="button" class="btn btn-primary" @click="pesquisar()">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div v-if="loading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <table v-else class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Quantidade</th>
                            <!-- <th scope="col">Ações</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="attendant in attendants.data" :key="attendant.id">
                            <td scope="row">{{ attendant.name }}</td>
                            <td scope="row">{{ attendant.email }}</td>
                            <td scope="row">{{ chatsMax(attendant.chats) }}</td>
                            <!-- <td scope="row">Listar meus chats</td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link, key) in attendants.links" :key="key" class="page-item"
                            :class="{ 'active': link.active }">
                            <a class="page-link" href="#" @click.prevent="pagination(link.url)" v-html="link.label"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import dayjs from 'dayjs';

export default {
    data() {
        return {
            attendants: {
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
        this.getAttendants();
    },
    methods: {
        pesquisar() {
            this.getAttendants('admin/chat/attendants/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getAttendants(url);
            }
        },
        getAttendants(url = 'admin/chat/attendants/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.attendants = response.data.attendants;
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false
                });
        },
        formatDate(date) {
            return dayjs(date).format('DD/MM/YYYY HH:mm:ss');
        },
        chatsMax(chatsByAttendants) {
            if (!Array.isArray(chatsByAttendants) || chatsByAttendants.length === 0) {
                return '0';
            }

            return chatsByAttendants.length.toString();
        }
    }
}
</script>