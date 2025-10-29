<template>
    <div class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-3 col-12">
                    <h5 class="mb-0">SystemCategory</h5>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter"
                            placeholder="Buscar..." />
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 col-12 text-md-end">
                    <a :href="urlCreate" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder de linha (sem dados ainda) -->
                        <tr v-for="category in this.system_categories.data">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td>
                                <span>
                                    <span v-if="!category.active" class="badge text-bg-danger">Desativado</span>
                                    <span v-else class="badge text-bg-success">Ativado</span>
                                </span>
                            </td>
                            <td>
                                <a :href="urlEdit.replace('_id', category.id)" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1" @click="deleteRegister(category.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button
                                    :class="['btn btn-sm ms-1', category.active ? 'btn-outline-danger' : 'btn-outline-success']"
                                    @click="disable(category)">
                                    <i :class="category.active ? 'bi bi-x-circle' : 'bi bi-check-circle'"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2">
            <nav v-if="system_categories.links.length > 0">
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li v-for="(link, i) in system_categories.links" :key="i"
                        :class="['page-item', { active: link.active, disabled: !link.url }]">
                        <a class="page-link" href="#" v-html="link.label" @click.prevent="pagination(link.url)"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        urlCreate: String,
        urlEdit: String,
    },
    data() {
        return {
            loading: false,
            searchFilter: '',
            system_categories: {
                data: [],
                links: []
            },
        }
    },
    mounted() {
        this.getSystemCategories();
    },
    methods: {
        search() {
            this.getSystemCategories('admin/system-category/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getComgetSystemCategoriespanies(url);
            }
        },
        getSystemCategories(url = 'admin/system-category/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.system_categories = response.data.items;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        disable(category) {
            let word = category.active ? 'desativar' : 'ativar';
            this.confirmYesNo(`Deseja realmente ${word} a empresa?`).then(() => {
                axios.post(`/admin/system-category/disable/${category.id}`)
                    .then(response => {
                        const updated = response.data.item;
                        const index = this.system_categories.data.findIndex(c => c.ID === updated.id);
                        this.system_categories.data.splice(index, 1, updated);
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {

                    });
            });
        },
        deleteRegister(id) {
            this.confirmYesNo('Excluir Categoria?').then(() => {
                this.loading = true;
                axios.delete('/admin/system-category/delete/' + id)
                    .then(response => {
                        this.getSystemCategories();
                        this.alertSuccess('Excluido com sucesso!');
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {
                        this.loading = false;
                    });
            });
        },
    }
}
</script>