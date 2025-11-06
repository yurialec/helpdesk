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
                            <div class="border rounded p-3 mb-4 bg-light-subtle">
                                <h6 class="fw-bold text-secondary mb-3">
                                    <i class="bi bi-building me-1"></i> Dados da Empresa
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Empresa</label>
                                        <select class="form-select" v-model="ticket.company_id" required
                                            @change="listSystems(ticket.company_id)">
                                            <option disabled value="">Selecione a empresa</option>
                                            <option v-for="company in companies" :key="company.id" :value="company.id">
                                                {{ company.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sistema</label>
                                        <select class="form-select" v-model="ticket.system_id" required>
                                            <option disabled value="">Selecione o sistema</option>
                                            <option v-for="system in systems" :key="system.id" :value="system.id">
                                                {{ system.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded p-3 mb-4 bg-light-subtle">
                                <h6 class="fw-bold text-secondary mb-3">
                                    <i class="bi bi-diagram-3 me-1"></i> Classificação do Ticket
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Grupo</label>
                                        <select class="form-select" v-model="ticket.group_id" required>
                                            <option disabled value="">Selecione o grupo</option>
                                            <option v-for="group in groups" :key="group.id" :value="group.id">
                                                {{ group.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Categoria</label>
                                        <select class="form-select" v-model="ticket.category_id" required>
                                            <option disabled value="">Selecione a categoria</option>
                                            <option v-for="category in categories" :key="category.id"
                                                :value="category.id">
                                                {{ category.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">SLA</label>
                                        <select class="form-select" v-model="ticket.sla_id" required>
                                            <option disabled value="">Selecione o SLA</option>
                                            <option v-for="sla in slas" :key="sla.id" :value="sla.id">
                                                {{ sla.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded p-3 mb-4 bg-light-subtle">
                                <h6 class="fw-bold text-secondary mb-3">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Classificação de Gravidade
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo</label>
                                        <select class="form-select" v-model="ticket.type" required>
                                            <option disabled value="">Selecione o tipo</option>
                                            <option value="incident">Incidente</option>
                                            <option value="service_request">Solicitação de Serviço</option>
                                            <option value="problem">Problema</option>
                                            <option value="change">Mudança</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Impacto</label>
                                        <select class="form-select" v-model="ticket.impact" required>
                                            <option disabled value="">Selecione o impacto</option>
                                            <option value="low">Baixo</option>
                                            <option value="medium">Médio</option>
                                            <option value="high">Alto</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Urgência</label>
                                        <select class="form-select" v-model="ticket.urgency" required>
                                            <option disabled value="">Selecione a urgência</option>
                                            <option value="low">Baixa</option>
                                            <option value="medium">Média</option>
                                            <option value="high">Alta</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Prioridade</label>
                                        <select class="form-select" v-model="ticket.priority_id" required>
                                            <option disabled value="">Selecione a prioridade</option>
                                            <option v-for="priority in priorities" :key="priority.id"
                                                :value="priority.id">
                                                {{ priority.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded p-3 mb-4 bg-light-subtle">
                                <h6 class="fw-bold text-secondary mb-3">
                                    <i class="bi bi-pencil-square me-1"></i> Detalhes
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label">Assunto</label>
                                    <input type="text" class="form-control" v-model="ticket.subject" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <textarea class="form-control" rows="5" v-model="ticket.description"
                                        required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prazo</label>
                                    <input type="date" class="form-control" v-model="ticket.due_date">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm" :disabled="loading">
                                    <span v-if="loading"><i class="bi bi-hourglass-split me-1"></i> Salvando...</span>
                                    <span v-else><i class="bi bi-check-circle me-1"></i> Salvar</span>
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
                company_id: '',
                system_id: '',
                subject: '',
                description: '',
                due_date: '',
                status_id: '',
                priority_id: 1,
                category_id: 1,
                group_id: 1,
                sla_id: 1,
                type: 'incident',
                impact: 'medium',
                urgency: 'medium',
            },
            priorities: [],
            companies: [],
            status: [],
            systems: [],
            slas: [],
            categories: [],
            groups: [],
        };
    },
    mounted() {
        this.listCompanies();
        this.listPriorities();
        this.listStatus();
        this.listSla();
        this.listCategories();
        this.listGroups();
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
        listSla() {
            this.loading = true;
            axios.get('/admin/tickets/list-sla/')
                .then(response => {
                    this.slas = response.data.items;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        listCategories() {
            this.loading = true;
            axios.get('/admin/tickets/list-category/')
                .then(response => {
                    this.categories = response.data.items;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        listGroups() {
            this.loading = true;
            axios.get('/admin/tickets/list-groups/')
                .then(response => {
                    this.groups = response.data.items;
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
            this.ticket.status_id = 1;

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
