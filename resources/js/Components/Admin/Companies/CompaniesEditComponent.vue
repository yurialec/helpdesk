<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    {{ step === 1 ? 'Editar Empresa' : 'Gerenciar Sistemas da Empresa' }}
                </h5>
            </div>

            <!-- LINHA DE ETAPAS -->
            <div class="d-flex justify-content-center align-items-center mt-4 mb-3">
                <div v-for="stage in steps" :key="stage.id" class="text-center mx-3">
                    <div :class="[
                        'rounded-circle d-flex align-items-center justify-content-center border',
                        step === stage.id ? 'bg-primary text-white border-primary' :
                            step > stage.id ? 'bg-success text-white border-success' :
                                'bg-light text-secondary border-secondary'
                    ]" style="width: 40px; height: 40px; margin: 0 auto;">
                        {{ stage.id }}
                    </div>
                    <small :class="[
                        'd-block mt-2',
                        step === stage.id ? 'text-primary fw-bold' : 'text-muted'
                    ]">
                        {{ stage.label }}
                    </small>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <!-- STEP 1 - Empresa -->
                        <form v-if="step === 1" @submit.prevent="nextStep" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="company.name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CNPJ</label>
                                <input type="text" class="form-control" v-model="company.cnpj" required
                                    @input="validateCnpj" v-mask="'##.###.###/####-##'">
                                <div v-if="validCnpj === false" class="alert alert-danger mt-2 mb-0 p-2 py-1">
                                    CNPJ inválido.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" v-model="company.email" required
                                    @input="validateEmail">
                                <div v-if="validEmail === false" class="alert alert-danger mt-2 mb-0 p-2 py-1">
                                    E-mail inválido.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" v-model="company.phone" @input="onPhoneInput"
                                    v-mask="['(##) #####-####', '(##) ####-####']" required />
                                <div v-if="validPhone === false" class="alert alert-danger mt-2 mb-0 p-2 py-1">
                                    Telefone inválido.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" v-model="company.address" required>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm">Próximo</button>
                            </div>
                        </form>

                        <!-- STEP 2 - Sistemas -->
                        <div v-if="step === 2">
                            <!-- FORMULÁRIO PARA ADICIONAR SISTEMAS -->
                            <form @submit.prevent="addSystem" autocomplete="off">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" class="form-control" placeholder="Nome do sistema"
                                        v-model="system.name" required>

                                    <select class="form-select" v-model="system.category_id" required>
                                        <option value="" disabled>Categoria</option>
                                        <option v-for="cat in system_categories" :key="cat.id" :value="cat.id">
                                            {{ cat.name }}
                                        </option>
                                    </select>
                                </div>

                                <textarea class="form-control mt-2" rows="2" v-model="system.description"
                                    placeholder="Descrição (opcional)"></textarea>

                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus-lg"></i> Adicionar
                                </button>
                            </form>

                            <!-- LISTA DE SISTEMAS -->
                            <div class="mt-4">
                                <h6 class="text-muted mb-2">Sistemas cadastrados:</h6>

                                <ul class="list-group list-group-flush">
                                    <li v-for="(s, i) in company.systems" :key="i"
                                        class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ s.name }}</strong>
                                            <small class="d-block text-muted">
                                                {{ getCategoryName(s.category_id) }}
                                            </small>
                                            <small v-if="s.description" class="text-muted">
                                                {{ s.description }}
                                            </small>
                                        </div>
                                        <button class="btn btn-outline-danger btn-sm" @click="removeSystem(i)">
                                            <i class="bi bi-trash"></i> Remover
                                        </button>
                                    </li>
                                </ul>

                                <div v-if="!company.systems.length" class="text-muted fst-italic mt-2">
                                    Nenhum sistema cadastrado.
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="prevStep">Voltar</button>
                                <button type="button" class="btn btn-success btn-sm" @click="save">
                                    Salvar Alterações
                                </button>
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

export default {
    props: {
        id: [String, Number],
        urlIndex: String,
    },
    data() {
        return {
            loading: false,
            step: 1,
            steps: [
                { id: 1, label: 'Empresa' },
                { id: 2, label: 'Sistemas' },
            ],
            validEmail: null,
            validCnpj: null,
            validPhone: null,
            company: {
                name: '',
                cnpj: '',
                email: '',
                phone: '',
                address: '',
                systems: [],
            },
            system: {
                name: '',
                description: '',
                category_id: '',
            },
            system_categories: [],
        }
    },
    mounted() {
        this.find(this.id);
        this.findSystemCategories();
    },
    methods: {
        find(id) {
            axios.get(`/admin/companies/find/${id}`)
                .then(response => {
                    this.company = response.data.item;
                    this.validEmail = this.validCnpj = this.validPhone = true;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        findSystemCategories() {
            axios.get('/admin/companies/list-system-categories')
                .then(res => { this.system_categories = res.data.items })
                .catch(err => this.alertDanger(err));
        },
        getCategoryName(id) {
            const c = this.system_categories.find(x => x.id === id);
            return c ? c.name : 'Sem categoria';
        },
        nextStep() {
            if (!this.validEmail || !this.validCnpj || !this.validPhone) {
                this.alertDanger('Verifique os campos obrigatórios e tente novamente.');
                return;
            }
            this.step = 2;
        },
        prevStep() {
            this.step = 1;
        },
        addSystem() {
            if (!this.system.name) {
                this.alertDanger('Informe o nome do sistema.');
                return;
            }
            if (!this.system.category_id) {
                this.alertDanger('Informe a categoria do sistema.');
                return;
            }

            this.company.systems.push({ ...this.system });
            this.system = { name: '', description: '', category_id: '' };
        },
        removeSystem(i) {
            this.company.systems.splice(i, 1);
        },
        validateEmail() {
            const pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/;
            this.validEmail = pattern.test(this.company.email);
        },
        validateCnpj() {
            let cnpj = this.company.cnpj.replace(/[^\d]+/g, '');
            if (cnpj.length !== 14) return this.validCnpj = false;
            let tamanho = cnpj.length - 2;
            let numeros = cnpj.substring(0, tamanho);
            let digitos = cnpj.substring(tamanho);
            let soma = 0, pos = tamanho - 7;
            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }
            let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) return this.validCnpj = false;
            tamanho++;
            numeros = cnpj.substring(0, tamanho);
            soma = 0; pos = tamanho - 7;
            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            this.validCnpj = (resultado == digitos.charAt(1));
        },
        onPhoneInput(e) {
            const raw = e.target.value.replace(/\D/g, '');
            this.validatePhone(raw);
        },
        validatePhone(phone) {
            this.validPhone = true;
            if (!(phone.length >= 10 && phone.length <= 11)) return this.validPhone = false;
            if (phone.length === 11 && parseInt(phone.substring(2, 3)) !== 9) return this.validPhone = false;
            for (let n = 0; n < 10; n++) {
                if (phone === new Array(11).join(n) || phone === new Array(12).join(n))
                    return this.validPhone = false;
            }
        },
        save() {
            const data = {
                ...this.company,
                cnpj: this.company.cnpj.replace(/\D/g, ''),
                phone: this.company.phone.replace(/\D/g, ''),
            };

            axios.put(`/admin/companies/update/${this.id}`, data)
                .then(() => {
                    this.alertSuccess('Empresa e sistemas atualizados com sucesso!');
                    this.step = 1;
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
