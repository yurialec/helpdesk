<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3 text-md-left text-center mb-2 mb-md-0">
                        <h3>Empresas</h3>
                    </div>
                    <div class="col-12 col-md-6 text-center mb-2 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="searchFilter" />
                            <button type="button" class="btn btn-primary" @click="pesquisar()">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 text-md-end text-end">
                        <a :href="urlCreateCompanies" type="button" class="btn btn-primary btn-sm">Cadastrar</a>
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
                            <th scope="col">CNPJ</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="company in companies.data" :key="company.id">
                            <td scope="row">{{ company.name }}</td>
                            <td scope="row">{{ company.cnpj }}</td>
                            <td scope="row">{{ company.email }}</td>
                            <td scope="row">
                                <a href="#" class="btn">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="#" class="btn">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="btn">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link, key) in companies.links" :key="key" class="page-item"
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
import { Modal } from 'bootstrap';

export default {
    props: {
        urlCreateCompanies: String
    },
    data() {
        return {
            companies: {
                data: [],
                links: []
            },
            searchFilter: '',
            alertStatus: null,
            msg: [],
            loading: null,
        };
    },
    computed: {

    },
    mounted() {
        this.getCompanies();
    },
    methods: {
        pesquisar() {
            this.getCompanies('admin/tickets/companies/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getCompanies(url);
            }
        },
        getCompanies(url = 'admin/tickets/companies/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.companies = response.data.companies;
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false
                });
        },
        formatDate(date) {
            return dayjs(date).format('DD/MM/YYYY HH:mm:ss');
        },
    }
}
</script>