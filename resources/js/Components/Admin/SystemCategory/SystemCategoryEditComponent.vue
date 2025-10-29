<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar SystemCategory</h5>
                <small class="text-muted">ID: {{ id }}</small>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="category.name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control mt-2" rows="3" v-model="category.description"
                                    placeholder="Descrição"></textarea>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: [String, Number],
        urlIndex: String,
    },
    data() {
        return {
            loading: false,
            category: {
                name: '',
                description: '',
            },
        }
    },
    mounted() {
        this.find(this.id);
    },
    methods: {
        find(id) {
            this.loading = true;
            axios.get(`/admin/system-category/find/${id}`)
                .then(response => {
                    this.category = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        save() {

            this.loading = true;
            axios.put(`/admin/system-category/update/${this.id}`, this.category)
                .then(() => {
                    this.alertSuccess('Empresa e sistemas atualizados com sucesso!');
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>