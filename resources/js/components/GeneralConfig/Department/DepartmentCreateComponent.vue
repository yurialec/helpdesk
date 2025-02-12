<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <h4>Cadastrar Departamento</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <form method="POST" action="" @submit.prevent="save()" class="col-lg-8" autocomplete="off">
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
                        </div>
                        <div class="row mt-5">
                            <div class="col-sm-6">
                                <div class="text-start">
                                    <a :href="urlIndexCompanies" class="btn btn-secondary btn-sm">Voltar</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-end">
                                    <button class="btn btn-primary btn-sm" type="submit">Cadastrar</button>
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

export default {
    props: {
        urlIndexCompanies: String,
    },
    data() {
        return {
            company: {
                name: '',
                cnpj: '',
                address: '',
                email: '',
                phone: '',
                responsible_manager: '',
            },
            validEmail: null,
            messages: [],
            alertStatus: [],
        };
    },
    mounted() {
    },
    methods: {
        validateEmail() {
            const emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            this.validEmail = emailPattern.test(this.company.email);
        },
        save() {
            axios.post('admin/general-configs/companies/store', this.company)
                .then(response => {
                    this.alertStatus = true;
                    this.messages = response.data;
                    window.scrollTo(0, 0);
                })
                .catch(errors => {
                    this.alertStatus = false;
                    this.messages = errors.response;
                });

        },
    }
}
</script>