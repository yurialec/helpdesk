<template>
    <div class="container-fluid px-4 mt-2">
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else class="card">
            <div class="card-header">
                <h4>Editar Empresa</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <form method="POST" action="" @submit.prevent="updateCompany()" class="col-lg-8" autocomplete="off">
                        <div v-if="alertStatus === true" class="alert alert-success alert-dismissible fade show"
                            role="alert">
                            <i class="fa-regular fa-circle-check"></i> Registro cadastrado com sucesso
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div v-if="alertStatus === false" class="alert alert-danger alert-dismissible fade show"
                            role="alert">
                            <i class="fa-regular fa-circle-xmark"></i> Erro ao atualizar registro
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome da Empresa</label>
                                    <input type="text" class="form-control" required v-model="company.name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" required v-model="company.email"
                                        @input="validateEmail" autocomplete="off">
                                    <small v-if="validEmail === false" class="text-danger">
                                        E-mail inválido.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CNPJ</label>
                                    <input type="text" class="form-control" v-mask="'##.###.###/####-##'" required
                                        v-model="company.cnpj">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Endereço</label>
                                    <input type="text" class="form-control" required v-model="company.address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="text" placeholder="(00) 00000-0000"
                                        v-mask="['(##) ####-####', '(##) #####-####']" class="form-control" required
                                        v-model="company.phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Responsável</label>
                                    <input type="text" class="form-control" required
                                        v-model="company.responsible_manager">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Setores</label>
                                    <multiselect label="name" track-by="id" v-model="departmentsSelected"
                                        :options="departments" :multiple="true">
                                    </multiselect>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-5">
                            <div class="col-sm-6">
                                <div class="text-start">
                                    <a :href="urlIndexCompanies" class="btn btn-secondary btn-sm">Voltar</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-end">
                                    <button class="btn btn-primary btn-sm" type="submit">Atualizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Multiselect from 'vue-multiselect';

export default {
    components: { Multiselect },
    props: {
        id: Number,
        urlIndexCompanies: String,
    },
    data() {
        return {
            loading: false,
            company: [],
            validEmail: null,
            messages: [],
            alertStatus: [],
            departmentsSelected: [],
            departments: [],
        }
    },
    mounted() {
        this.findCompany();
        this.listDepartments();
    },
    methods: {
        findCompany() {
            this.loading = true;
            axios.get('/admin/general-configs/companies/find/' + this.id)
                .then(response => {
                    this.company = response.data.company;
                    this.departmentsSelected = this.company.departments.map(department => {
                        return {
                            id: department.id,
                            name: department.name
                        };
                    });
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false
                });
        },
        listDepartments() {
            this.loading = true;
            axios.get('/admin/general-configs/companies/list-departments/')
                .then(response => {
                    this.departments = response.data.departments;
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false
                });
        },
        updateCompany() {
            this.loading = true;

            axios.put('/admin/general-configs/companies/update/' + this.id, { data: this.company, departments: this.departmentsSelected })
                .then(response => {
                    if (response.data.status) {
                        this.alertStatus = true;
                    } else {
                        console.error('Erro ao atualizar empresa:', response.data.message);
                    }
                })
                .catch(errors => {
                    console.log(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>