<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3 text-md-left text-center mb-2 mb-md-0">
                        <h3>Setores</h3>
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
                        <a :href="urlCreateDepartment" type="button" class="btn btn-primary btn-sm">Cadastrar</a>
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
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Criado em</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="department in departments.data" :key="department.id">
                            <td scope="row">{{ department.id }}</td>
                            <td scope="row">{{ department.name }}</td>
                            <td scope="row">{{ formatDate(department.created_at) }}</td>
                            <td scope="row">
                                <button style="color: #333; padding: 0;" type="button" class="btn"
                                    @click="detailsToModal(department)" data-bs-toggle="modal"
                                    data-bs-target="#modalDetails">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a :href="urlEditDepartment.replace(':id', department.id)"
                                    style="color: #0D6EFD; padding: 0;" class="btn">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" style="color: red; padding: 0;" class="btn"
                                    @click="confirmarExclusao(department.id)" data-bs-toggle="modal"
                                    data-bs-target="#modalDeleteDepartment">
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
                        <li v-for="(link, key) in departments.links" :key="key" class="page-item"
                            :class="{ 'active': link.active }">
                            <a class="page-link" href="#" @click.prevent="pagination(link.url)" v-html="link.label"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="modal fade" id="modalDeleteDepartment" tabindex="-1" aria-labelledby="modalDeleteDepartmentLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteDepartmentLabel">Confirmação de Exclusão</h5>
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
                        <h1 class="modal-title fs-5" id="modalDetailsLabel">Dados do Departamento</h1>
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
                                    <th>Criado em</th>
                                    <td>{{ formatDate(modalData.created_at) }}</td>
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
        urlCreateDepartment: String,
        urlEditDepartment: String,
    },
    data() {
        return {
            departments: {
                data: [],
                links: []
            },
            searchFilter: '',
            alertStatus: null,
            msg: [],
            loading: null,
            modalData: {
                id: '',
                name: '',
                created_at: '',
            },
            departmentToDelete: null,
        };
    },
    computed: {

    },
    mounted() {
        this.getDepartments();
    },
    methods: {
        pesquisar() {
            this.getDepartments('admin/general-configs/department/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getDepartments(url);
            }
        },
        getDepartments(url = 'admin/general-configs/department/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.departments = response.data.departments;
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false
                });
        },
        formatDate(date) {
            return dayjs(date).format('DD/MM/YYYY HH:mm:ss');
        },
        detailsToModal(department) {
            this.modalData.id = department.id;
            this.modalData.name = department.name;
            this.modalData.created_at = department.created_at;
        },
        closeModal() {
            this.modalData.id = '';
            this.modalData.name = '';
            this.modalData.created_at = '';
        },
        confirmarExclusao(departmentId) {
            this.departmentToDelete = departmentId;
        },
        excluirRegistro() {
            if (this.departmentToDelete !== null) {
                axios.delete(`admin/general-configs/department/delete/${this.departmentToDelete}`)
                    .then(() => {
                        this.getDepartments();
                        this.fecharModal('modalDeleteDepartment');
                    })
                    .catch(() => {
                        this.fecharModal('modalDeleteDepartment');
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