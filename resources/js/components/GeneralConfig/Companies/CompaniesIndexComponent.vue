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
                                <button style="color: #333; padding: 0;" type="button" class="btn"
                                    @click="detailsToModal(company)" data-bs-toggle="modal"
                                    data-bs-target="#modalDetails">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a :href="urlEditCompanies.replace(':id', company.id)"
                                    style="color: #0D6EFD; padding: 0;" class="btn">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" style="color: red; padding: 0;" class="btn"
                                    @click="confirmarExclusao(company.id)" data-bs-toggle="modal"
                                    data-bs-target="#modalDeleteCompany">
                                    <i class="bi bi-trash3"></i>
                                </button>
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

        <div class="modal fade" id="modalDeleteCompany" tabindex="-1" aria-labelledby="modalDeleteCompanyLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteCompanyLabel">Confirmação de Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja deletar este registro?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" @click="excluirRegistro">Excluir</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal DETAILS-->
        <div class="modal fade" id="modalDetails" name="modalDetails" tabindex="-1" aria-labelledby="modalDetailsLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDetailsLabel">Dados da Empresa</h1>
                        <button type="button" @click="closeModal()" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ modalData.id }}</td>
                                </tr>
                                <tr>
                                    <th>Nome</th>
                                    <td>{{ modalData.name }}</td>
                                </tr>
                                <tr>
                                    <th>CNPJ</th>
                                    <td>{{ modalData.cnpj }}</td>
                                </tr>
                                <tr>
                                    <th>Endereço</th>
                                    <td>{{ modalData.address || 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>E-mail</th>
                                    <td>{{ modalData.email }}</td>
                                </tr>
                                <tr>
                                    <th>Telefone</th>
                                    <td>{{ modalData.phone || 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Responsável</th>
                                    <td>{{ modalData.responsible_manager || 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Criado em</th>
                                    <td>{{ formatDate(modalData.created_at) }}</td>
                                </tr>
                                <tr>
                                    <th>Atualizado em</th>
                                    <td>{{ formatDate(modalData.updated_at) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="closeModal()" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
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
        urlCreateCompanies: String,
        urlEditCompanies: String,
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
            modalData: {
                id: '',
                cnpj: '',
                address: '',
                email: '',
                name: '',
                phone: '',
                responsible_manager: '',
                created_at: '',
                updated_at: '',
            },
            companyToDelete: null,
        };
    },
    computed: {

    },
    mounted() {
        this.getCompanies();
    },
    methods: {
        pesquisar() {
            this.getCompanies('admin/general-configs/companies/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getCompanies(url);
            }
        },
        getCompanies(url = 'admin/general-configs/companies/list') {
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
        detailsToModal(company) {

            this.modalData.id = company.id;
            this.modalData.cnpj = company.cnpj;
            this.modalData.address = company.address;
            this.modalData.email = company.email;
            this.modalData.name = company.name;
            this.modalData.phone = company.phone;
            this.modalData.responsible_manager = company.responsible_manager;
            this.modalData.created_at = company.created_at;
            this.modalData.updated_at = company.updated_at;
        },
        closeModal() {
            this.modalData.id = '';
            this.modalData.cnpj = '';
            this.modalData.address = '';
            this.modalData.email = '';
            this.modalData.name = '';
            this.modalData.phone = '';
            this.modalData.responsible_manager = '';
            this.modalData.created_at = '';
            this.modalData.updated_at = '';
        },
        confirmarExclusao(companyId) {
            this.companyToDelete = companyId;
        },
        excluirRegistro() {
            if (this.companyToDelete !== null) {
                axios.delete(`admin/general-configs/companies/delete/${this.companyToDelete}`)
                    .then(() => {
                        this.getCompanies();
                        this.fecharModal('modalDeleteCompany');
                    })
                    .catch(() => {
                        this.fecharModal('modalDeleteCompany');
                    });
            }
        },
        fecharModal(modalId) {
            const modalElement = document.getElementById(modalId);
            if (modalElement) {
                const modalInstance = Modal.getInstance(modalElement) || new Modal(modalElement);
                modalInstance.hide();
            }
        }
    }
}
</script>