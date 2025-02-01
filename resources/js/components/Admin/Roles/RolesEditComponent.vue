<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <h4>Editar perfil</h4>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div v-if="alertStatus === true" class="alert alert-success alert-dismissible fade show"
                            role="alert">
                            <i class="fa-regular fa-circle-check"></i> Registro atualizado com sucesso
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div v-if="alertStatus === false" class="alert alert-danger alert-dismissible fade show"
                            role="alert">
                            <i class="fa-regular fa-circle-xmark"></i> {{ this.messages }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div v-if="loading" class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div v-else>
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control" disabled v-model="role.role.name">
                            </div>
                            <div class="form-group mt-3">
                                <multiselect label="label" track-by="id" v-model="permissionsSelected"
                                    :options="permissions" :multiple="true">
                                </multiselect>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="text-start" style="margin-top: 10px;">
                                        <a :href="urlIndexRole" class="btn btn-secondary btn-sm">Voltar</a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-end" style="margin-top: 10px;">
                                        <a href="#" class="btn btn-primary btn-sm" @click="salvar()">
                                            Salvar Alterações
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        roleById: {
            type: String,
            required: true
        },
        urlIndexRole: String,
    },
    data() {
        return {
            role: {
                role: JSON.parse(this.roleById),
            },
            permissionsSelected: [],
            alertStatus: null,
            messages: '',
            permissions: [],
            loading: null,
        };
    },
    computed: {
    },
    mounted() {
        this.listPermissions();
    },
    methods: {
        salvar() {

            if (this.permissionsSelected?.length === 0) {
                this.alertStatus = false;
                this.messages = 'Nenhuma permissão selecionada';
                return;
            }

            let arrItems = this.permissionsSelected.map((p) => p.id);

            axios.post('/admin/roles/update/' + this.role.role.id, { permissions: arrItems })
                .then(response => {
                    this.alertStatus = true;
                })
                .catch(errors => {
                    this.alertStatus = false;
                    this.messages = errors.response;
                });
        },
        listPermissions() {
            this.loading = true;
            axios.get('/admin/roles/list-permissions')
                .then(response => {
                    this.permissions = response.data.permissions;
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>
