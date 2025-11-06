<template>
    <div class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-12 col-md-auto me-auto">
                    <h5 class="mb-0">Chamados</h5>
                </div>
                <div class="col-12 col-md-auto **ms-auto** d-flex align-items-center justify-content-end gap-2">
                    <a :href="urlCreate" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel-fill me-1"></i> Filtro
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-0">
                                <div class="p-3" style="min-width: 280px; background-color: #f8f9fa; border-radius: .5rem;">
                                    <h6 class="dropdown-header mb-3">
                                        Aplicar filtros
                                    </h6>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Protocolo</label>
                                        <input class="form-control form-control-sm" placeholder="Digite o protocolo"
                                            v-model="searchFilter.protocol">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Empresa</label>
                                        <select class="form-select form-select-sm" v-model="searchFilter.company_id"
                                            @change="listSystems(searchFilter.company_id)">
                                            <option value="" selected>Todas</option>
                                            <option v-for="company in companies" :key="company.id" :value="company.id">
                                                {{ company.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Sistema</label>
                                        <select class="form-select form-select-sm" v-model="searchFilter.system_id">
                                            <option value="" selected>Todos</option>
                                            <option v-for="system in systems" :key="system.id" :value="system.id">
                                                {{ system.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Assunto</label>
                                        <input class="form-control form-control-sm" placeholder="Digite o assunto"
                                            v-model="searchFilter.subject">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Prioridade</label>
                                        <select class="form-select form-select-sm" v-model="searchFilter.priority_id">
                                            <option value="">Todas</option>
                                            <option v-for="priority in priorities" :key="priority.id"
                                                :value="priority.id">
                                                {{ priority.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Status</label>
                                        <select class="form-select form-select-sm" v-model="searchFilter.status_id">
                                            <option value="">Todos</option>
                                            <option v-for="sts in status" :key="sts.id" :value="sts.id">
                                                {{ sts.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Prazo</label>
                                        <input class="form-control form-control-sm" type="date"
                                            v-model="searchFilter.due_date">
                                    </div>
                                    <div class="d-grid gap-2 mt-4">
                                        <button class="btn btn-sm btn-success shadow-sm" @click="search()">
                                            <i class="bi bi-search me-1"></i> Aplicar filtros
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" @click="clearFilter()">
                                            <i class="bi bi-x-circle me-1"></i> Limpar
                                        </button>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Protocolo</th>
                            <th>Empresa/Sistema</th>
                            <th>Assunto</th>
                            <th class="text-center">Prioridade</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Prazo</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ticket in tickets.data" :key="ticket.id">
                            <td>{{ ticket.id }}</td>
                            <td>{{ ticket.protocol }}</td>
                            <td>{{ ticket.company.name }}/{{ ticket.system.name }}</td>
                            <td class="text-truncate" style="max-width: 200px;" :title="ticket.subject">
                                {{ ticket.subject }}
                            </td>
                            <td>
                                <span class="badge w-100 text-center"
                                    :style="{ backgroundColor: ticket.priority?.color_code }">
                                    {{ ticket.priority?.name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge w-100 text-center"
                                    :style="{ backgroundColor: ticket.status?.color_code }">
                                    {{ ticket.status?.name }}
                                </span>
                            </td>
                            <td class="text-end">{{ formatDate(ticket.due_date) }}</td>
                            <td class="text-end">
                                <a :href="urlEdit.replace('_id', ticket.id)" class="btn btn-sm btn-outline-primary me-1"
                                    title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <!-- <button class="btn btn-sm btn-outline-secondary" title="Visualizar"
                                    @click="viewTicket(ticket)">
                                    <i class="bi bi-eye"></i>
                                </button> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2" v-if="tickets.links.length > 0">
            <nav>
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li v-for="(link, i) in tickets.links" :key="i"
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
            searchFilter: {
                company_id: '',
                system_id: '',
                subject: '',
                protocol: '',
                priority_id: '',
                status_id: '',
                due_date: '',
            },
            loading: false,
            tickets: {
                data: [],
                links: []
            },
            companies: [],
            systems: [],
            priorities: [],
            status: [],
        };
    },
    mounted() {
        this.getTickets();
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
        listSystems(companyId) {
            if (!companyId) {
                this.systems = [];
                this.searchFilter.system_id = '';
                return;
            }
            this.loading = true;
            axios.get(`/admin/tickets/list-systems/${companyId}`)
                .then(response => {
                    this.systems = response.data.item;
                    this.searchFilter.system_id = '';
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
        clearFilter() {

            this.searchFilter.company_id = '';
            this.searchFilter.system_id = '';
            this.searchFilter.subject = '';
            this.searchFilter.protocol = '';
            this.searchFilter.priority_id = '';
            this.searchFilter.status_id = '';
            this.searchFilter.due_date = '';

            this.getTickets();
        },
        search() {
            this.getTickets('admin/tickets/list', this.searchFilter);
        },
        pagination(url) {
            if (url) this.getTickets(url);
        },
        getTickets(url = 'admin/tickets/list', params = {}) {
            this.loading = true;
            axios.get(url, { params })
                .then(response => {
                    this.tickets = response.data.items;
                })
                .catch(error => {
                    this.alertDanger(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        formatDate(dateStr) {
            if (!dateStr) return '—';
            const date = new Date(dateStr);
            return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
        },
        viewTicket(ticket) {
            alert(`Ticket ${ticket.protocol}\n\nAssunto: ${ticket.subject}\nEmpresa: ${ticket.company?.name}`);
        },
        convertPriority(name) {
            switch (name) {
                case 'Low':
                    return 'Baixo';
                case 'Medium':
                    return 'Médio';
                case 'High':
                    return 'Alto';
                case 'Urgent':
                    return 'Urgente';
            }
        },
        convertStatus(name) {
            switch (name) {
                case 'Open':
                    return 'Aberto';
                case 'In Progress':
                    return 'Em Progresso';
                case 'Awaiting Client':
                    return 'Aguardando Cliente';
                case 'Resolved':
                    return 'Resolvido';
                case 'Closed':
                    return 'F';
            }
        }
    },
};
</script>
