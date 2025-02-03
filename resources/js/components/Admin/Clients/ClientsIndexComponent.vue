<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3 text-md-left text-center mb-2 mb-md-0">
                        <h3>Usuários</h3>
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
            <div v-if="loading" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">CPF/CNPJ</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="client in clients.data" :key="client.id">
                                    <td scope="row">{{ client.cpf_cnpj }}</td>
                                    <td>{{ client.name }}</td>
                                    <td>{{ client.phone }}</td>
                                    <td>
                                        <a href="#">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link, key) in clients.links" :key="key" class="page-item"
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

export default {
    props: {
        urlCreateUser: String,
    },
    data() {
        return {
            clients: {
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
        this.getClients();
    },
    methods: {
        pesquisar() {
            this.getClients('admin/chat/clients/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getClients(url);
            }
        },
        getClients(url = 'admin/chat/clients/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.clients = response.data.clients;
                })
                .catch(errors => {
                    console.log(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
    }
}
</script>