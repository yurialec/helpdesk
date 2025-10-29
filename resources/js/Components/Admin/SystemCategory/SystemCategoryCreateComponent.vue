<template>
    <div class="container-fluid px-2" v-loading="{ show: loading }">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar SystemCategory</h5>
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
    methods: {
        save() {
            this.loading = true;
            axios.post('/admin/system-category/store', this.category)
                .then(() => {
                    this.alertSuccess('Empresa e sistemas salvos com sucesso!');
                    this.clearForm();
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        clearForm() {
            this.category = {
                name: '',
                description: ''
            };
        },
    }
}
</script>