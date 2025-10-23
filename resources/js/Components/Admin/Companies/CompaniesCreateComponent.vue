<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Empresa</h5>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="company.name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CNPJ</label>
                                <input type="text" class="form-control" v-model="company.cnpj" required
                                    @input="validateCnpj" v-mask="'##.###.###/####-##'">
                                <div v-if="validCnpj === false" class="alert alert-danger mt-2 mb-0 p-2 py-1"
                                    role="alert">
                                    Cnpj inválido.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" v-model="company.email" required
                                    @input="validateEmail">
                                <div v-if="validEmail === false" class="alert alert-danger mt-2 mb-0 p-2 py-1"
                                    role="alert">
                                    E-mail inválido.
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" v-model="company.phone" @input="onPhoneInput"
                                    v-mask="['(##) #####-####', '(##) ####-####']" required />
                                <div v-if="validPhone === false" class="alert alert-danger mt-2 mb-0 p-2 py-1">
                                    Telefone inválido
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" v-model="company.address" required>
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
import axios from 'axios';

export default {
    props: {
        urlIndex: String,
    },
    data() {
        return {
            loading: false,
            validEmail: null,
            validCnpj: null,
            validPhone: null,
            company: {
                name: '',
                cnpj: '',
                email: '',
                phone: '',
                address: '',
            }
        }
    },
    methods: {
        validateEmail() {
            const pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/;
            this.validEmail = pattern.test(this.company.email);
        },
        validateCnpj() {

            let cnpj = this.company.cnpj.replace(/[^\d]+/g, '');

            let tamanho = cnpj.length - 2;
            let numeros = cnpj.substring(0, tamanho);
            let digitos = cnpj.substring(tamanho);
            let soma = 0;
            let pos = tamanho - 7;
            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }
            let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) return this.validCnpj = false;;

            tamanho = tamanho + 1;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)) this.validCnpj = false;

            this.validCnpj = true;
        },
        onPhoneInput(e) {
            const raw = e.target.value.replace(/\D/g, '');
            this.validatePhone(raw);
        },
        validatePhone(phone) {
            this.validPhone = true;

            // validações sobre o valor local
            if (!(phone.length >= 10 && phone.length <= 11)) {
                this.validPhone = false;
                return;
            }

            if (phone.length === 11 && parseInt(phone.substring(2, 3)) !== 9) {
                this.validPhone = false;
                return;
            }

            for (let n = 0; n < 10; n++) {
                if (phone === new Array(11).join(n) || phone === new Array(12).join(n)) {
                    this.validPhone = false;
                }
            }

            const codigosDDD = [11, 12, 13, 14, 15, 16, 17, 18, 19,
                21, 22, 24, 27, 28, 31, 32, 33, 34,
                35, 37, 38, 41, 42, 43, 44, 45, 46,
                47, 48, 49, 51, 53, 54, 55, 61, 62,
                64, 63, 65, 66, 67, 68, 69, 71, 73,
                74, 75, 77, 79, 81, 82, 83, 84, 85,
                86, 87, 88, 89, 91, 92, 93, 94, 95,
                96, 97, 98, 99];

            if (!codigosDDD.includes(parseInt(phone.substring(0, 2)))) {
                this.validPhone = false;
            }

            if (new Date().getFullYear() < 2017) this.validPhone = true;

            if (phone.length === 10 && [2, 3, 4, 5, 7].indexOf(parseInt(phone.substring(2, 3))) === -1) {
                this.validPhone = false;
            }
        },
        save() {
            if (!this.validEmail) {
                this.alertDanger('Insira um e-mail valido');
                return;
            }
            if (!this.validCnpj) {
                this.alertDanger('Insira um cnpj valido');
                return;
            }
            if (!this.validPhone) {
                this.alertDanger('Insira um telefone valido');
                return;
            }

            const data = {
                name: this.company.name,
                cnpj: this.company.cnpj.replace(/[^0-9]/g, ''),
                email: this.company.email,
                phone: this.company.phone.replace(/[^0-9]/g, ''),
                address: this.company.address,
            };

            axios.post('/admin/companys/store', data)
                .then(res => {
                    this.alertSuccess('Operação realizada com sucesso!');
                    window.scrollTo(0, 0);
                    this.clearForm();
                })
                .catch(err => {
                    this.alertDanger(errors);
                    window.scrollTo(0, 0);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        clearForm() {
            this.company.name = '';
            this.company.cnpj = '';
            this.company.email = '';
            this.company.phone = '';
            this.company.address = '';

            this.validEmail = null;
            this.validCnpj = null;
            this.validPhone = null;
        }
    }
}
</script>