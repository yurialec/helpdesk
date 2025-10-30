<template>
    <div class="container-fluid px-2" v-loading="{ show: loading }">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Cadastrar Ticket</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Empresa</label>
                                <select class="form-select" v-model="ticket.company_id" required
                                    @change="listSystems(ticket.company_id)">
                                    <option v-for="company in companies" :key="company.id" :value="company.id">
                                        {{ company.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sistema</label>
                                <select class="form-select" v-model="ticket.system_id" required>
                                    <option v-for="system in systems" :key="system.id" :value="system.id">
                                        {{ system.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Assunto</label>
                                <input type="text" class="form-control" v-model="ticket.subject" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" rows="5" v-model="ticket.description"
                                    required></textarea>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" v-model="ticket.status_id" required>
                                        <option disabled value="">Selecione o status</option>
                                        <option v-for="sts in status" :key="sts.id" :value="sts.id">
                                            {{ sts.name }}
                                        </option>
                                    </select>
                                </div> -->

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioridade</label>
                                    <select class="form-select" v-model="ticket.priority_id" required>
                                        <option disabled value="">Selecione a prioridade</option>
                                        <option v-for="priority in priorities" :key="priority.id" :value="priority.id">
                                            {{ priority.name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prazo</label>
                                    <input type="date" class="form-control" v-model="ticket.due_date">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm" :disabled="loading">
                                    <span v-if="loading"><i class="bi bi-hourglass-split me-1"></i> Salvando...</span>
                                    <span v-else>Salvar</span>
                                </button>
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
            ticket: {
                subject: '',
                description: '',
                due_date: '',
                status_id: '',
                priority_id: ''
            },
            priorities: {},
            status: {},
            companies: {}
        };
    },
    mounted() {
        this.listCompanies();
        this.listPriorities();
        this.listStatus();
    },
    methods: {
        listCompanies() {
            this.loading = true;
            axios.get('/admin/tickets/list-companies/')
                .then(response => {
                    this.companies = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        listPriorities() {
            this.loading = true;
            axios.get('/admin/tickets/list-priorities/')
                .then(response => {
                    this.priorities = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        listStatus() {
            this.loading = true;
            axios.get('/admin/tickets/list-status/')
                .then(response => {
                    this.status = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        listSystems(companyId) {
            if (!companyId) {
                this.systems = [];
                this.ticket.system_id = '';
                return;
            }
            this.loading = true;
            axios.get(`/admin/tickets/list-systems/${companyId}`)
                .then(response => {
                    this.systems = response.data.item;
                    this.ticket.system_id = '';
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        save() {
            this.loading = true;
            axios.post('/admin/tickets/store', this.ticket)
                .then(response => {
                    this.alertSuccess('Ticket cadastrado com sucesso!');
                    window.location.href = this.urlIndex;
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
